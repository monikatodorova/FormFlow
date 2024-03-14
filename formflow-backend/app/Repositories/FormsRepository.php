<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FormsRepository {

    /**
     * @param Project $project
     * @return array
     */
    public static function getAllFormsForProject(Project $project) {
        return $project->forms->makeHidden(['project_id'])->append(['secret']);
    }



}
