<?php

/**
 * TimesheetController class file
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Services\TimesheetFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TimesheetController class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class TimesheetController extends Controller
{
    public function __construct(private TimesheetFilter $timesheetFilterService)
    {

    }
    /**
     * Return all timesheets
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Timesheet::with(['user', 'project'])->get());
    }

    /**
     * Create timesheets
     * 
     * @param Request $request request data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'task_name' => 'required|string',
                'date' => 'required|date',
                'hours' => 'required|integer|min:1',
                'user_id' => 'required|exists:users,id',
                'project_id' => 'required|exists:projects,id',
            ]
        );

        $timesheet = Timesheet::create($validated);
        return response()->json($timesheet, 201);
    }

    /**
     * Show timesheets
     * 
     * @param Timesheet $timesheet Timesheet
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Timesheet $timesheet): JsonResponse
    {
        return response()->json($timesheet->load(['user', 'project']));
    }
    /**
     * Update timesheets
     * 
     * @param Request   $request   Request data
     * @param Timesheet $timesheet Timesheet
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Timesheet $timesheet): JsonResponse
    {
        $validated = $request->validate(
            [
                'task_name' => 'string',
                'date' => 'date',
                'hours' => 'integer|min:1',
                'user_id' => 'exists:users,id',
                'project_id' => 'exists:projects,id',
            ]
        );

        $timesheet->update($validated);
        return response()->json($timesheet);
    }
    /**
     * Delete timesheets
     * 
     * @param Timesheet $timesheets Timesheet
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Timesheet $timesheet): JsonResponse
    {
        $timesheet->delete();
        return response()->json(['message' => 'Timesheet deleted successfully']);
    }

    /**
     * Get filtered timesheets
     *
     * @param Request $request Request 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterTimesheets(Request $request): JsonResponse
    {

        $response = $this->timesheetFilterService->filter($request);

        return response()->json($response);
    }
}
