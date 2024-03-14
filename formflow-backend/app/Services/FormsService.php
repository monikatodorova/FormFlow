<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Form;
use App\Repositories\FormsRepository;
use App\Repositories\ProjectsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FormsService {

    /**
     * Returns all projects for current user.
     * @return Response
     */
    public static function getAllFormsForProject(Project $project) {
        return new Response([
            'status' => 'success',
            'forms' => FormsRepository::getAllFormsForProject($project),
        ], 200);
    }
}