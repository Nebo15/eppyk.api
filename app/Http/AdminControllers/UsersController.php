<?php
/**
 * Author: Paul Bardack paul.bardack@gmail.com http://paulbardack.com
 * Date: 14.02.16
 * Time: 19:59
 */

namespace App\Http\AdminControllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\Response;
use Illuminate\Support\Facades\Gate;
use Laravel\Lumen\Routing\Controller as BaseController;

class UsersController extends BaseController
{
    public function __construct()
    {
        if (Gate::denies('create-user')) {
            abort(403, 'only for admin account');
        }
    }

    public function index(Response $response)
    {
        return $response->view('users/index.twig', ['users' => User::all()]);
    }

    public function delete($id)
    {
        User::findById($id)->delete();

        return redirect('/admin/users');
    }

    public function create(User $model)
    {
        return view('users/form.twig', ['model' => $model]);
    }

    public function edit(Request $request)
    {
        /** @var User $model */
        $model = User::findOrNew($request->get('id'));
        if ($pw = $request->get('password')) {
            $model->password = \Hash::make($pw);
        }
        $model->fill($request->request->all())->save();

        return redirect('/admin/users', 301);
    }

    public function update($id, Response $response)
    {
        return $response->view('users/form.twig', ['model' => User::findById($id)]);
    }
}
