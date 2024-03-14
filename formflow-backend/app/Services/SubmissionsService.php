<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Form;
use App\Repositories\SubmissionsRepository;
use Illuminate\Http\Response;

class SubmissionsService {

    /**
     * Returns paginated submissions for forms that are under the provided form.
     * @param Form $form
     * @param null $submissionStatus
     * @param int $page
     * @param int $perPage
     * @return \App\Http\Resources\SubmissionsCollection
     */
    public static function getAllSubmissionsForForm(Form $form, $submissionStatus = null, $page = 0, $perPage = 20) {
        return SubmissionsRepository::getAllSubmissionsForForm($form, $submissionStatus, $page, $perPage);
    }
}