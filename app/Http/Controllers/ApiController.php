<?php
/**
 * Author: Paul Bardack paul.bardack@gmail.com http://paulbardack.com
 * Date: 09.02.16
 * Time: 17:43
 */

namespace Http\Controllers;

use App\Models\Base;
use Illuminate\Http\Request;
use App\Http\Services\Response;

use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function create(Request $request, Response $response, Base $model)
    {
        
    }

    public function read(Request $request, Response $response, Base $model, $id)
    {

    }

    public function update(Request $request, Response $response, Base $model, $id)
    {

    }

    public function delete(Response $response, Base $model, $id)
    {

    }
}
