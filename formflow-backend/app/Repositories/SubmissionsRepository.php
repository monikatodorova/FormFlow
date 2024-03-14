<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Form;
use App\Models\Submission;

class SubmissionsRepository {

    public const RESULTS_PER_PAGE = 20;

    /**
     * Gets all submissions for the provided form, and filters them by their status if needed.
     * @param Form $form
     * @param null $submissionStatus
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public static function getAllSubmissionsForForm(Form $form, $submissionStatus = null, $page = 0, $perPage = self::RESULTS_PER_PAGE) {
        $leads = Submission::query();
        $leads->where('form_id', '=', $form->getId());
        if($submissionStatus && in_array($submissionStatus, Submission::STATUS_OPTIONS)) {
            $leads->where('status', '=', $submissionStatus);
        }
        $totalLeads = $leads->count();
        $leads->orderByDesc('id');

        if((!is_numeric($perPage) && strtolower($perPage) !== 'all') || $perPage <= 0) {
            $perPage = self::RESULTS_PER_PAGE;
        }

        if(strtolower($perPage) === 'all') {
            $items = $leads->get();
        } else {
            $pagination = $leads->cursorPaginate($perPage);
            $items = $pagination->items();
        }

        return [
            'items' => $items,
            'cursor' => isset($pagination) ? ($pagination->nextCursor() ? $pagination->nextCursor()->encode() : null) : null,
            'total' => $totalLeads,
        ];
    }

    /**
     * Total number of submissions for project on given date
     * @param Project $project
     * @param $date
     * @return int
     */
    public static function getTotalSubmissionsForProjectOnDate(Project $project, $date)
    {
        return 0;
        // return Submission::query()->whereIn('form_id', FormsRepository::getAllFormIdsForProject($project))->whereDate('created_at', '=', $date)->count();
    }

}
