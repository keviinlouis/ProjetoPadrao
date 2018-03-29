<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 28/03/2018
 * Time: 14:20
 */

namespace App\Http\Controllers;


use App\Entities\Pagamento;
use App\Http\Requests\Request;
use Log;

class MoipController
{
    CONST PAYMENT = 'PAYMENT';

    /**
     * @param Request $request
     */
    public function webhook(Request $request)
    {

        Log::channel('moip')->info('Atualização Moip');
        $data = $request->toArray();
        
        list($tipo, $evento) = explode('.', $data['event']);
        
        Log::channel('moip')->info('Evento Moip: '.$evento.' Tipo: '.$tipo);
        
        $evento = Pagamento::moipStatusToVendaStatus($evento);
        
        Log::channel('moip')->info('Evento PetLovers: '.$evento);
        
        if($tipo == self::PAYMENT){
            $id = $data['resource']['payment']['id'];


            if(!$pagamento = Pagamento::whereMoipId($id)->first()){
                Log::channel('moip')->error('Venda '.$id.' não encontrada: '.$evento);
                return;
            }
            if($pagamento->status == $evento){
                Log::channel('moip')->error('Venda '.$id.' para o mesmo status: '.$evento);
                return;
            }

            $pagamento->update(['status' => $evento]);

            if(Pagamento::isPago($evento)){
                $pagamento->anuncio->update(['ativo' => 1]);
            }


        }


    }

}