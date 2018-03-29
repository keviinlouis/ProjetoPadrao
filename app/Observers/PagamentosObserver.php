<?php
/**
 * Created by PhpStorm.
 * User: DevMaker
 * Date: 02/03/2018
 * Time: 18:45
 */

namespace App\Observers;

use App\Entities\Dono;
use App\Entities\Pagamento;
use Illuminate\Mail\Message;

class PagamentosObserver
{

    /**
     * @param Dono $dono
     */
    public function created(Pagamento $pagamento)
    {
        $this->criarHistorico($pagamento);
    }

    public function updated(Pagamento $pagamento)
    {
        $this->criarHistorico($pagamento);
    }

    public function criarHistorico(Pagamento $pagamento)
    {
        $pagamento->historico()->create([
            'valor' => $pagamento->valor,
            'descricao' => $pagamento->descricao,
            'status' => $pagamento->status,
        ]);
    }

}