<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function welcome(Response $response)
    {

    }

    public function questions(Request $request, Response $response)
    {
        $this->validate($request, [
            'locale' => 'sometimes|required',
            'updated_after' => 'sometimes|required|date',
            'updated_before' => 'sometimes|required|date',
        ]);
        $filters = ['locale', 'updated_after', 'updated_before'];
        $where = [];
        foreach ($filters as $filter) {
            if ($request->has($filter)) {
                $where[$filter] = $request->get($filter);
            }
        }
    }
}
