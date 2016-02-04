<?php

namespace App\Http\AdminControllers;

use App\Http\Services\Response;
use App\Models\Locale;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class LocalesController extends BaseController
{
    public function index(Response $response)
    {
        return $response->view('locales/index.twig', ['locales' => Locale::all()]);
    }

    public function delete($id)
    {
        Locale::findById($id)->delete();
        return redirect('/admin/locales');
    }

    public function create(Locale $model)
    {
        return view('locales/form.twig', ['model' => $model]);
    }

    public function edit(Request $request)
    {
        $model = Locale::findOrNew($request->get('id'));
        $params = $request->request->all();
        if (!array_key_exists('active', $params)) {
            $params['active'] = 0;
        }
        if (!array_key_exists('default', $params)) {
            $params['default'] = 0;
        }
        $model->fill($params)->save();
        return redirect('/admin/locales', 301);
    }

    public function update($id, Response $response)
    {
        return $response->view('locales/form.twig', ['model' => Locale::findById($id)]);
    }
}
