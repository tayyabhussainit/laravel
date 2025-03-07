<?php

/**
 * AttributeFilter class file
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

use App\Models\Attribute;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * AttributeFilter class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Service
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class AttributeFilter
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
        $query = Attribute::query();
        if ($request->has('filters')) {
            foreach ($request->filters as $key => $value) {
                if (in_array($key, ['name', 'type'])) {
                    $query->where($key, 'LIKE', "%$value%");
                }
            }
        }

        return $query->get();
    }
}