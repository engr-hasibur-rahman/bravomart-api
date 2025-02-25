<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminEmailDetailsResource;
use App\Http\Resources\Admin\AdminEmailResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Mail\TestEmail;
use App\Models\EmailTemplate;
use App\Models\OrderRefundReason;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailTemplateManageController extends Controller
{
    public function __construct(protected EmailTemplate $emailTemplate, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->emailTemplate->translationKeys;
    }

    public function allEmailTemplate(Request $request)
    {
        $query = EmailTemplate::query();

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        if (!empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->subject)) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }
        $emailTemplates = $query->paginate(10);

        return response()->json([
            'data' => AdminEmailResource::collection($emailTemplates),
            'meta' => new PaginationResource($emailTemplates),
        ]);


    }

    public function addEmailTemplate(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:email_templates,name',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $body = strip_tags($request->body, '<p><a><strong><em><h1><h2><ul><ol><li><br>'); // Allow some tags

        EmailTemplate::create([
            'type' => $request->type,
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $body,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Email template added successfully',
        ], 201);
    }

    public function emailTemplateDetails(Request $request)
    {
        $validator = Validator::make(['id' => $request->id], [
            'id' => 'required|integer|exists:email_templates,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $email_template = EmailTemplate::find($request->id);
        if ($email_template) {
            return response()->json(new AdminEmailDetailsResource($email_template), 200);
        } else {
            return response()->json([
                'message' => __('data_not_found'),
            ], 404);
        }
    }

    public function editEmailTemplate(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:email_templates,id',
            'name' => 'required|string|unique:email_templates,name,' . $request->id,
            'subject' => 'sometimes|required|string',
            'body' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find and update the email template
        $emailTemplate = EmailTemplate::findOrFail($request->id);
        $this->createOrUpdateTranslation($request, $emailTemplate->id, 'App\Models\EmailTemplate', $this->translationKeys());
        $emailTemplate->update($request->only(['name', 'subject', 'body']));
        return response()->json([
            'message' => 'Email template updated successfully',
        ], 201);
    }

    public function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        if (empty($request['translations'])) {
            return false;  // Return false if no translations are provided
        }

        $translations = [];
        foreach ($request['translations'] as $translation) {
            foreach ($colNames as $key) {
                // Fallback value if translation key does not exist
                $translatedValue = $translation[$key] ?? null;

                // Skip translation if the value is NULL
                if ($translatedValue === null) {
                    continue; // Skip this field if it's NULL
                }

                // Check if a translation exists for the given reference path, ID, language, and key
                $trans = $this->translation
                    ->where('translatable_type', $refPath)
                    ->where('translatable_id', $refid)
                    ->where('language', $translation['language_code'])
                    ->where('key', $key)
                    ->first();

                if ($trans) {
                    // Update the existing translation
                    $trans->value = $translatedValue;
                    $trans->save();
                } else {
                    // Prepare new translation entry for insertion
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }

        // Insert new translations if any
        if (!empty($translations)) {
            $this->translation->insert($translations);
        }

        return true;
    }

    public function deleteEmailTemplate(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:email_templates,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find and delete the email template
        $emailTemplate = EmailTemplate::findOrFail($request->id);
        $emailTemplate->delete();

        return response()->json(['message' => 'Email template deleted successfully'], 200);
    }

    // Change Status of Email Template
    public function changeStatus(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:email_templates,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the email template by its ID
        $emailTemplate = EmailTemplate::find($request->id);

        if (!$emailTemplate) {
            return response()->json(['message' => 'Email template not found'], 404);
        }
        // Update the status
        $emailTemplate->status = $request->status;
        // Save the updated template
        $emailTemplate->save();

        return response()->json([
            'message' => 'Email template status updated successfully',
        ], 200);
    }

}
