<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * App\Entities\Pagamento
 *
 * @property int $id
 * @property float $valor
 * @property string $descricao
 * @property int $status
 * @property string|null $moip_id
 * @property int $anuncio_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|PagamentoHistorico[] $historico
 * @method static Builder|Pagamento pago()
 * @method static Builder|Pagamento whereAnuncioId($value)
 * @method static Builder|Pagamento whereCreatedAt($value)
 * @method static Builder|Pagamento whereDescricao($value)
 * @method static Builder|Pagamento whereId($value)
 * @method static Builder|Pagamento whereMoipId($value)
 * @method static Builder|Pagamento whereStatus($value)
 * @method static Builder|Pagamento whereUpdatedAt($value)
 * @method static Builder|Pagamento whereValor($value)
 * @mixin \Eloquent

 */
class Pagamento extends Entity
{
	public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'valor',
		'descricao',
		'moip_id',
		'status',
	];

    CONST CRIADO = 1;
    CONST AGUARDANDO = 2;
    CONST ANALISANDO = 3;
    CONST PRE_AUTORIZADO = 4;
    CONST AUTORIZADO = 5;
    CONST CANCELADO = 6;
    CONST REEMBOLSADO = 7;
    CONST ESTORNO = 8;
    CONST CONCLUIDO = 9;


    /**
     * @param $status
     * @return int|null
     */
    static public function moipStatusToVendaStatus($status)
    {
        switch ($status) {
            case 'CREATED':
                return self::CRIADO;
                break;
            case 'WAITING':
                return self::ANALISANDO;
                break;
            case 'IN_ANALYSIS':
                return self::ANALISANDO;
                break;
            case 'PRE_AUTHORIZED':
                return self::PRE_AUTORIZADO;
                break;
            case 'AUTHORIZED':
                return self::AUTORIZADO;
                break;
            case 'CANCELLED':
                return self::CANCELADO;
                break;
            case 'REFUNDED':
                return self::REEMBOLSADO;
                break;
            case 'SETTLED':
                return self::CONCLUIDO;
                break;
            case 'REVERSED':
                return self::ESTORNO;
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
                self::PRE_AUTORIZADO, self::AUTORIZADO, self::CONCLUIDO
            ]) !== false;
    }

    /**
     * @param $evento
     * @return bool
     */
    static public function isRecusado($evento)
    {
        return in_array($evento, [
                self::ESTORNO, self::REEMBOLSADO, self::CANCELADO
            ]) !== false;
    }


    public function scopePago(Builder $query)
    {
        return $query->whereIn('status', [self::PRE_AUTORIZADO, self::AUTORIZADO, self::CONCLUIDO]);
    }

    public function historico()
    {
        return $this->hasMany(PagamentoHistorico::class);
    }
}
