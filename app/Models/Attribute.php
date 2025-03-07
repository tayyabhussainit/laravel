<?php

/**
 * Attribute class file
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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Attribute class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class Attribute extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'type'];
}
