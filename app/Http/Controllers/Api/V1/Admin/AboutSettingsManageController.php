<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Resources\Admin\AdminAboutSettingsResource;
use App\Models\Page;
use App\Models\Translation;
use Illuminate\Http\Request;

class AboutSettingsManageController extends Controller
{
    public function __construct(protected Page $aboutSetting, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->aboutSetting->translationKeys;
    }

}
