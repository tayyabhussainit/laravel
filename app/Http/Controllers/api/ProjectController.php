<?php

/**
 * ProjectController class file
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

use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Services\ProjectFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * ProjectController class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class ProjectController extends Controller
{

    public function __construct(private ProjectFilter $projectFilterService)
    {

    }
    /**
     * Return all projects
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Project::with('attributes.attribute')->get());
    }

    /**
     * Create project
     * 
     * @param Request $request request data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'name' => 'required|string',
                'status' => 'required|in:active,inactive',
            ]
        );
        $validated['created_by'] = $request->user()->id;
        $project = Project::create($validated);
        return response()->json($project, 201);
    }

    /**
     * Show project
     * 
     * @param Project $project Project
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        return response()->json($project->load('attributes.attribute'));
    }

    /**
     * Update project
     * 
     * @param Request $request Request data
     * @param Project $project Project
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate(
            [
                'name' => 'required|string',
                'status' => 'in:active,inactive',
            ]
        );
        $validated['updated_by'] = $request->user()->id;
        $project->update($validated);
        return response()->json($project);
    }

    /**
     * Delete project
     * 
     * @param Project $project Project
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }

    /**
     * Set project attributes
     *
     * @param Request $request Request 
     * @param Project $project Project
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAttributes(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate(
            [
                'attributes' => 'required|array',
                'attributes.*.name' => 'required|string|exists:attributes,name',
                'attributes.*.value' => 'required',
            ]
        );

        foreach ($validated['attributes'] as $attr) {
            $attribute = Attribute::where('name', $attr['name'])->first();

            AttributeValue::updateOrCreate(
                ['attribute_id' => $attribute->id, 'entity_id' => $project->id],
                ['value' => $attr['value']]
            );
        }

        return response()->json(['message' => 'Attributes updated successfully']);
    }

    /**
     * Get filtered project
     *
     * @param Request $request Request 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterProjects(Request $request): JsonResponse
    {

        $response = $this->projectFilterService->filter($request);

        return response()->json($response);
    }
}
