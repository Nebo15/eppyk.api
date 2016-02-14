<?php
/**
 * Author: Paul Bardack paul.bardack@gmail.com http://paulbardack.com
 * Date: 12.02.16
 * Time: 13:47
 */

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;

/**
 * Class User
 * @package App\Models
 * @property string $login
 * @property string $password
 * @property string $role
 */
class User extends Base implements AuthenticatableInterface
{
    use Authenticatable;

    protected $fillable = ['login', 'role'];
}
