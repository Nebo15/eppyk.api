<?php
/**
 * Author: Paul Bardack paul.bardack@gmail.com http://paulbardack.com
 * Date: 11.02.16
 * Time: 13:10
 */

namespace App\Http\AdminControllers;

use App\Exceptions\AnswerNotFoundException;
use App\Models\Answer;
use App\Models\Locale;
use Illuminate\Http\Request;
use App\Http\Services\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class AnswersController extends BaseController
{
    public function index(Response $response, $locale)
    {
        if ($locale == 'default') {
            $locale_model = Locale::where(['default' => true])->first();
            if (!$locale_model) {
                return redirect("/admin/locales/?no_default=true", 301);
            }
        } else {
            $locale_model = Locale::findByLocale($locale);
            if (!$locale_model) {
                return redirect("/admin/locales/create?locale=$locale", 301);
            }
        }

        return $response->view('answers/index.twig', [
            'locales' => Locale::all(),
            'default_locale' => $locale_model->code,
            'answers' => $locale_model->answers()->get(),
        ]);
    }

    public function create(Answer $model, $locale)
    {
        return view('answers/form.twig', ['model' => $model, 'locale' => $locale]);
    }

    public function update($id, Response $response)
    {
        $locale = Locale::findByAnswerId($id);

        return $response->view('answers/form.twig', [
            'model' => $locale->getAnswer($id),
            'locale' => $locale->code
        ]);
    }

    public function delete($id)
    {
        $locale = Locale::findByAnswerId($id);
        $locale->deleteAnswer($id);
        $locale->save();

        return redirect('/admin/answers/' . $locale->code);
    }

    public function edit(Request $request)
    {
        $locale = $request->get('locale');
        $model = Locale::findByLocale($locale);
        if (!$model) {
            return redirect("/admin/locales/create?locale=$locale", 301);
        }
        var_dump($model->default);
        try {
            $answer = $model->getAnswer($request->get('id'));
        } catch (AnswerNotFoundException $e) {
            $answer = new Answer;
        }
        $params = $request->request->all();
        if (!array_key_exists('active', $params)) {
            $params['active'] = false;
        }
        $answer->fill($params);
        $model->addAnswer($answer);
        $model->save();

        return redirect('/admin/answers/' . $locale, 301);
    }
}
