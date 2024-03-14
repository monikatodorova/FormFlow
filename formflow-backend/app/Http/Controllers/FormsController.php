<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Project;
use App\Services\FormsService;
use App\Services\SubmissionsService;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function index(Project $project) {
        return FormsService::getAllFormsForProject($project);
    }

    public function submissions(Project $project, Form $form, Request $request) {
        return SubmissionsService::getAllSubmissionsForForm($form, $request->get('status'), $request->get('page'), $request->get('perPage'));
    }
}
