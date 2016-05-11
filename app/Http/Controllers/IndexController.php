<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use Illuminate\Http\Request;
use App\Http\Services\Response;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Lumen\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function welcome(Response $response)
    {
        return $response->json('It works!');
    }

    public function locales(Request $request, Response $response)
    {
        $this->validate($request, [
            'locale' => 'sometimes|required|string',
            'updated_after' => 'sometimes|required|date',
            'updated_before' => 'sometimes|required|date',
        ]);

        $locales = [];
        if ($locale = $request->get('locale')) {
            $locales[] = Locale::findByLocale($locale);
        } else {
            /** @var Collection $locales */
            $locales = Locale::all()->sortBy('created_at');
        }

        $return = [];
        /** @var Locale $locale */
        foreach ($locales as $locale) {
            $return[] = $locale->toApiView(
                $request->get('with_answers'),
                $request->get('answers_page'),
                $request->get('answers_size')
            );
        }

        return $response->json($return);
    }

    public function answers(Request $request, Response $response, $locale)
    {
        $this->validate($request, [
            'updated_after' => 'sometimes|required|ISODate',
            'updated_before' => 'sometimes|required|ISODate',
        ]);

        $page = $request->get('page') > 0 ? $request->get('page') : 1;
        $pagination = [];
        if ($size = $request->get('size')) {
            $pagination = ['page' => intval($page), 'size' => intval($size)];
        }

        return $response->json(Locale::findByLocale($locale)->getAnswersPaginated(
            $page,
            $size,
            $request->get('updated_after'),
            $request->get('updated_before')
        ), 200, ['append' => env('META_APPEND')], $pagination);
    }

    public function login(Request $request, Response $response)
    {
        $result = \Auth::attempt([
            'login' => $request->get('login'),
            'password' => $request->get('password'),
        ], $request->get('remember'));

        return redirect($result ? '/admin/answers/default' : '/admin/login', 301);
    }
}
