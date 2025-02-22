<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestEmail;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailTemplateManageController extends Controller
{

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
        $emailTemplates = $query->get();

        if ($emailTemplates->count() > 0){
            return response()->json([
                'data' => $emailTemplates
            ]);
        }else{
            return response()->json([
                'message' =>  'No email templates found',
            ], 404);
        }

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
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $body,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Email template added successfully',
        ],201);
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
        $emailTemplate->update($request->only(['name', 'subject', 'body', 'status']));
        return response()->json([
            'message' => 'Email template updated successfully',
        ],201);
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
