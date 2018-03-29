<?php

namespace App\Entities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


/**
 * App\Entities\Cartao
 *
 * @property int $id
 * @property string $hash
 * @property int $ultimos_digitos
 * @property string $nome_completo
 * @property Carbon $data_nascimento
 * @property string $cpf
 * @property string $telefone
 * @property string $cep
 * @property string $rua
 * @property int $numero
 * @property string $cidade
 * @property string $estado
 * @property int $dono_id
 * @property string $bandeira
 * @property string $bairro
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Cartao whereCep($value)
 * @method static Builder|Cartao whereCidade($value)
 * @method static Builder|Cartao whereCpf($value)
 * @method static Builder|Cartao whereCreatedAt($value)
 * @method static Builder|Cartao whereDataNascimento($value)
 * @method static Builder|Cartao whereDonoId($value)
 * @method static Builder|Cartao whereEstado($value)
 * @method static Builder|Cartao whereHash($value)
 * @method static Builder|Cartao whereId($value)
 * @method static Builder|Cartao whereNomeCompleto($value)
 * @method static Builder|Cartao whereNumero($value)
 * @method static Builder|Cartao whereRua($value)
 * @method static Builder|Cartao whereTelefone($value)
 * @method static Builder|Cartao whereUltimosDigitos($value)
 * @method static Builder|Cartao whereUpdatedAt($value)
 * @method static Builder|Cartao whereBandeira($value)
 * @method static Builder|Cartao whereBairro($value)
 * @mixin \Eloquent
 */
class Cartao extends Entity
{
	protected $table = 'cartoes';
	public static $snakeAttributes = false;

	protected $casts = [
		'numero' => 'int',
		'dono_id' => 'int'
	];

	protected $dates = [
		'data_nascimento'
	];

	protected $fillable = [
		'hash',
		'ultimos_digitos',
		'nome_completo',
		'data_nascimento',
        'bandeira',
		'cpf',
		'telefone',
		'cep',
		'rua',
		'bairro',
		'numero',
		'cidade',
		'estado',
		'dono_id'
	];

    const MASTERCARD = 'MASTERCARD';
    const VISA = 'VISA';
    const AMEX = 'AMEX';
    const DINERS = 'DINERS';
    const HIPERCARD = 'HIPERCARD';
    const ELO = 'ELO';
    const HIPER = 'HIPER';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
	{
		// TODO Entidade Do Dono Do Cartão
        return $this->belongsTo(User::class);
	}

    public function setDataNascimentoAttribute($date)
    {
        $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $date)->toDateString();
    }

    public static function getBandeiras()
    {
        return [
            self::MASTERCARD,
            self::VISA,
            self::AMEX,
            self::DINERS,
            self::HIPERCARD,
            self::ELO,
            self::HIPER
        ];
    }

    public function isMastercard()
    {
        return $this->isBandeira(self::MASTERCARD);
    }

    public function isVisa()
    {
        return $this->isBandeira(self::VISA);
    }

    public function isAmex()
    {
        return $this->isBandeira(self::AMEX);
    }

    public function isDiners()
    {
        return $this->isBandeira(self::DINERS);
    }

    public function isHipercard()
    {
        return $this->isBandeira(self::HIPERCARD);
    }

    public function isElo()
    {
        return $this->isBandeira(self::ELO);
    }

    public function isHiper()
    {
        return $this->isBandeira(self::HIPER);
    }

    public function isBandeira($bandeira)
    {
        return $this->bandeira == $bandeira;
    }
}
