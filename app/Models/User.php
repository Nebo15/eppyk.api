<?php
/**
 * Author: Paul Bardack paul.bardack@gmail.com http://paulbardack.com
 * Date: 12.02.16
 * Time: 13:47
 */

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    use Authenticatable;
}
