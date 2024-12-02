<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Project;
use App\Services\FormsService;
use App\Services\SubmissionsService;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function index(Project $project) {
        return FormsService::getAllFormsForProject($project);
    }

    public function store(Project $project, Request $request) {
        return FormsService::createForm($project, $request->all());
    }

    public function generateForm(Project $project, Form $form, Request $request)
    {
        $description = $request->input('description');

        if (!$description) {
            return response()->json(['error' => 'Description is required.'], 400);
        }

        try {
            $formFields = FormsService::generateForm($description, $project, $form);
            return response()->json(['fields' => $formFields]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function details(Project $project, Form $form) {
        return FormsService::details($form);
    }

    public function preview(Form $form) {
        return FormsService::preview($form);
    }

    public function update(Project $project, Form $form, Request $request) {
        return FormsService::updateForm($form, $request->all());
    }

    public function delete(Project $project, Form $form) {
        return FormsService::delete($form);
    }

    public function submissions(Project $project, Form $form, Request $request) {
        return SubmissionsService::getAllSubmissionsForForm($form, $request->get('status'), $request->get('page'), $request->get('perPage'));
    }

    public function statistics(Project $project, Form $form, Request $request) {
        return StatisticsService::getStatisticsForForm($form, $request);
    }
}
