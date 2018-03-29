<?php

namespace App\Http\Controllers;

use App\Entities\User;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Log;

class RedefinirSenhaController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRedefinirSenhaFormUser(Request $request)
    {
        $route = route('user.redefinir-senha');
        if ($token = $request->get('token')) {
            $d = DB::table("recuperacao_senha_users")
                ->whereDate('expires_at', '>', now()->toDateTimeString())
                ->delete();

            Log::channel('recuperacao-senha')->info('Removido ' . $d . ' tokens expirados');

            $token = DB::table("recuperacao_senha_users")
                ->where('token', $token)
                ->first();

            if ($token) {
                $token = $token->token;
            }
        }
        return view('auth.passwords.reset', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function redefinirSenhaUser(Request $request)
    {
        $this->validate($request, $this->rulesUser());

        $model = User::whereEmail($request['email'])->first();

        DB::table("recuperacao_senha_users")
            ->where([['token', $request['token']], ['email', $request['email']]])
            ->delete();

        $model->update(['senha' => $request['senha']]);

        return view('auth.passwords.success');
    }

    /**
     * @return array
     */
    public function rulesUser(): array
    {
        return [
            'token' => ['required', Rule::exists('recuperacao_senha_users', 'token')->where(function (Builder $query) {
                $query->whereDate('expires_at', '<', now()->toDateTimeString());
            })],
            'email' => 'required|exists:recuperacao_senha_users,email|exists:users,email',
            'senha' => 'required|min:6|confirmed'
        ];
    }
}
