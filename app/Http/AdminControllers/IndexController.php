<?php

namespace App\Http\AdminControllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function index($template = '')
    {
        return view(((!$template) ? 'index' : $template ).'.twig');
    }
}
