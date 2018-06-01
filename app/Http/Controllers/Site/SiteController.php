<?php

/**
 * Created by PhpStorm.
 * User: DevMaker Backend
 * Date: 30/05/2018
 * Time: 15:24
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;
use Mail;
use Request;

class SiteController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('site.home.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function planos()
    {
        return view('site.planos.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function protecoes()
    {
        return view('site.protecoes.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contato()
    {
        return view('site.contato.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        $bodyStyle = "background-image:url(".asset('assets/images/login-bg.jpg').");";
        $bodyClass = 'backgrounded';
        $semFooter = true;
        return view('site.associado.login', get_defined_vars());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cadastro()
    {
        $bodyStyle = "background-image:url(".asset('assets/images/login-bg.jpg').");";
        $bodyClass = 'backgrounded';
        $semFooter = true;
        return view('site.associado.cadastro', get_defined_vars());
    }

    public function enviarEmailContato(Request $request){
        $dados =  $request->all();

        $validator = \Validator::make($dados, [
            'nome' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string',
            'mensagem' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        Mail::send('emails.contato', [ 'dados' => $dados ], function (Message $message) use ($dados) {
            $message->from('contato@anjo.com.br', 'Contato Admin');
            $message->to(['gustavo@clickskin.com.br', 'atendimento@clickskin.com.br']);
            $message->subject("Contato - Click Skin");
        });

        return response()->json([
            'success' => true,
            'message' => 'Email enviado com sucesso'
        ]);
    }

}