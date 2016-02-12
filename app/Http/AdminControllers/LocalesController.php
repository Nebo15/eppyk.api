<?php

namespace App\Http\AdminControllers;

use App\Models\Locale;
use Illuminate\Http\Request;
use App\Http\Services\Response;
use App\Exceptions\AdminRequiredException;
use Laravel\Lumen\Routing\Controller as BaseController;

class LocalesController extends BaseController
{
    public function __construct(Request $request, Response $response)
    {
        if('admin' !== $request->offsetGet('auth_user_role')){
            throw new AdminRequiredException;
        }
    }

    public function index(Request $request, Response $response)
    {
        return $response->view(
            'locales/index.twig',
            ['locales' => Locale::all(), 'no_default' => $request->has('no_default')]
        );
    }

    public function delete($id)
    {
        Locale::findById($id)->delete();

        return redirect('/admin/locales');
    }

    public function create(Request $request, Locale $model)
    {
        return view('locales/form.twig', ['model' => $model, 'locale_code' => $request->get('locale')]);
    }

    public function edit(Request $request)
    {
        /** @var Locale $model */
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
