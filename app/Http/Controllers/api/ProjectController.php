<?php

namespace App\Http\Controllers\api;

use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::with('attributes.attribute')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);
        $validated['created_by'] = $request->user()->id;
        $project = Project::create($validated);
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return response()->json($project->load('attributes.attribute'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'in:active,inactive',
        ]);
        $validated['updated_by'] = $request->user()->id;
        $project->update($validated);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {   
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function setAttributes(Request $request, Project $project)
    {
        $validated = $request->validate([
            'attributes' => 'required|array',
            'attributes.*.name' => 'required|string|exists:attributes,name',
            'attributes.*.value' => 'required',
        ]);

        foreach ($validated['attributes'] as $attr) {
            $attribute = Attribute::where('name', $attr['name'])->first();

            AttributeValue::updateOrCreate(
                ['attribute_id' => $attribute->id, 'entity_id' => $project->id],
                ['value' => $attr['value']]
            );
        }

        return response()->json(['message' => 'Attributes updated successfully']);
    }

    public function filterProjects(Request $request)
    {
        $query = Project::query();

        if ($request->has('filters')) {
            foreach ($request->filters as $key => $value) {
                if (in_array($key, ['name', 'status'])) {
                    $query->where($key, 'LIKE', "%$value%");
                } else {
                    $query->whereHas('attributes', function ($q) use ($key, $value) {
                        $q->whereHas('attribute', function ($attr) use ($key) {
                            $attr->where('name', $key);
                        })->where('value', 'LIKE', "%$value%");
                    });
                }
            }
        }

        return response()->json($query->get());
    }

}
