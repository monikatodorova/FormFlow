<?php

namespace App\Services;

use App\Models\Form;
use App\Models\Project;
use App\Models\Submission;
use App\Repositories\FormsRepository;
use App\Repositories\SubmissionsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatisticsService {

    /**
     * Return statistics for project
     * @param Project $project
     * @return Response
     */
    public static function getStatisticsForProject(Project $project) {
        return new Response([
            "submissions" => self::getSubmissionsStatisticsForProject($project),
        ], 200);
    }

    /**
     * Returns statistical breakdown of submissions for the provided project.
     * @param Project $project
     * @return array
     */
    private static function getSubmissionsStatisticsForProject(Project $project) {
        $today = date("Y-m-d");
        $week = date("Y-m-d", strtotime("-7 days"));
        $month = date("Y-m-d", strtotime("-30 days"));
        return [
            'today' => SubmissionsRepository::getTotalSubmissionsForProjectOnDate($project, $today),
            // 'week' => SubmissionsRepository::getTotalSubmissionsForProjectForPeriod($project, $week, $today),
            // 'month' => SubmissionsRepository::getTotalSubmissionsForProjectForPeriod($project, $month, $today),
            // 'total' => SubmissionsRepository::getTotalSubmissionsForProject($project),
        ];
    }

}