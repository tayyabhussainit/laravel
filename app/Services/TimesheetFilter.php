<?php

/**
 * TimesheetFilter class file
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Service
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */

namespace App\Services;

use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * TimesheetFilter class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Service
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class TimesheetFilter
{
    /**
     * Filter timesheets
     *
     * @param Request $request Request 
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filter(Request $request): Collection
    {
        $query = Timesheet::query();
        if ($request->has('filters')) {
            foreach ($request->filters as $key => $value) {
                if (in_array($key, ['task_name', 'date', 'user_id', 'project_id'])) {
                    $query->where($key, 'LIKE', "%$value%");
                }
            }
        }

        return $query->get();
    }
}