<?php

/**
 * AttributeController class file
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

use App\Models\Attribute;
use App\Services\AttributeFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * AttributeController class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class AttributeController extends Controller
{
    public function __construct(private AttributeFilter $attributeFilterService)
    {

    }
    /**
     * Return all attribute
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Attribute::all());
    }

    /**
     * Create attribute
     * 
     * @param Request $request request data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|unique:attributes,name',
                'type' => 'required|in:text,date,number'
            ]
        );

        $attribute = Attribute::create($validated);
        return response()->json($attribute, 201);
    }

    /**
     * Show attribute
     * 
     * @param Attribute $attribute Attribute
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Attribute $attribute): JsonResponse
    {
        return response()->json($attribute);
    }

    /**
     * Update attribute
     * 
     * @param Request   $request   Request data
     * @param Attribute $attribute Attribute
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Attribute $attribute): JsonResponse
    {
        $validated = $request->validate(
            [
                'name' => 'string|unique:attributes,name,' . $attribute->id,
                'type' => 'in:text,date,number',
            ]
        );

        $attribute->update($validated);
        return response()->json($attribute);
    }

    /**
     * Delete attribute
     * 
     * @param Attribute $attribute Attribute
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Attribute $attribute): JsonResponse
    {
        $attribute->delete();
        return response()->json(['message' => 'Attribute deleted successfully']);
    }

    /**
     * Get filtered attributes
     *
     * @param Request $request Request 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterAttributes(Request $request): JsonResponse
    {

        $response = $this->attributeFilterService->filter($request);

        return response()->json($response);
    }
}
