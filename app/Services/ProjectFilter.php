<?php

/**
 * ProjectFilter class file
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * ProjectFilter class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Service
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class ProjectFilter
{
    /**
     * Filter project
     *
     * @param Request $request Request 
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filter(Request $request): Collection
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

        return $query->with(['attributes.attribute'])->get();
    }
}