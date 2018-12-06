<?php
/**
 * PHP version 7.2
 *
 * @category Model
 * @package  App
 * @author   Predrag Vlajkovic <predrag.vlajkovic@gmail.com>
 * @license  http://softwarepieces.com/licence Private owned
 * @link     http://softwarepieces.com/
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Permission
 *
 * @category Model
 * @package  App
 * @author   Predrag Vlajkovic drPreAG <predrag.vlajkovic@gmail.com>
 * @license  http://softwarepieces.com/licence Private owned
 * @link     http://softwarepieces.com/
 */
class Permission extends Model
{
    /**
     * Relation
     *
     * @return \App\Role
     */
    public function inRole()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

}
