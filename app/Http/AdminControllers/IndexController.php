<?php

namespace App\Http\AdminControllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function index($template = '')
    {
        return redirect('/admin/locales', 301);
//        return view(((!$template) ? 'index' : $template ).'.twig');
    }
}
