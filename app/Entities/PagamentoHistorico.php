<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;

/**
 * App\Entities\PagamentoHistorico
 *
 * @property-read \App\Entities\Pagamento $pagamento
 * @mixin \Eloquent
 * @property int $id
 * @property float $valor
 * @property string $descricao
 * @property int $status
 * @property int $pagamento_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static Builder|PagamentoHistorico whereCreatedAt($value)
 * @method static Builder|PagamentoHistorico whereDescricao($value)
 * @method static Builder|PagamentoHistorico whereId($value)
 * @method static Builder|PagamentoHistorico wherePagamentoId($value)
 * @method static Builder|PagamentoHistorico whereStatus($value)
 * @method static Builder|PagamentoHistorico whereUpdatedAt($value)
 * @method static Builder|PagamentoHistorico whereValor($value)
 */
class PagamentoHistorico extends Entity
{
	public static $snakeAttributes = false;

	protected $casts = [
		'pagamento_id' => 'int'
	];

	protected $fillable = [
	    'valor',
        'descricao',
		'status',
		'pagamento_id'
	];

   
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pagamento()
    {
        return $this->belongsTo(Pagamento::class);
    }

    /**
     * @param $status
     * @return int|null
     */
    static public function moipStatusToVendaStatus($status)
    {
        switch ($status) {
            case 'CREATED':
                return Pagamento::CRIADO;
                break;
            case 'WAITING':
                return Pagamento::ANALISANDO;
                break;
            case 'IN_ANALYSIS':
                return Pagamento::ANALISANDO;
                break;
            case 'PRE_AUTHORIZED':
                return Pagamento::PRE_AUTORIZADO;
                break;
            case 'AUTHORIZED':
                return Pagamento::AUTORIZADO;
                break;
            case 'CANCELLED':
                return Pagamento::CANCELADO;
                break;
            case 'REFUNDED':
                return Pagamento::REEMBOLSADO;
                break;
            case 'SETTLED':
                return Pagamento::CONCLUIDO;
                break;
            case 'REVERSED':
                return Pagamento::ESTORNO;
                break;
            default:
                return null;
        }
    }

    /**
     * @param $evento
     * @return bool
     */
    static public function isPago($evento)
    {
        return in_array($evento, [
                Pagamento::PRE_AUTORIZADO, Pagamento::AUTORIZADO, Pagamento::CONCLUIDO
            ]) !== false;
    }

    /**
     * @param $evento
     * @return bool
     */
    static public function isRecusado($evento)
    {
        return in_array($evento, [
                Pagamento::ESTORNO, Pagamento::REEMBOLSADO, Pagamento::CANCELADO
            ]) !== false;
    }
}
