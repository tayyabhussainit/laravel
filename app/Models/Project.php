<?php

/**
 * Project class file
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Project class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class Project extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    /**
     * Relation to User
     * 
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relation to Timesheet
     * 
     * @return HasMany
     */
    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    /**
     * Relation to AttributeValue
     * 
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }
}
