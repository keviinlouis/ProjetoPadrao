<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;

/**
 * App\Entities\Mensagem
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $remetente_id
 * @property int $destinatario_id
 * @property string $texto
 * @property bool $aberto
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $room
 * @method static Builder|Mensagem chat($userOne, $userTwo)
 * @method static Builder|Mensagem whereAberto($value)
 * @method static Builder|Mensagem whereCreatedAt($value)
 * @method static Builder|Mensagem whereDestinatarioId($value)
 * @method static Builder|Mensagem whereId($value)
 * @method static Builder|Mensagem whereRemetenteId($value)
 * @method static Builder|Mensagem whereRoom($value)
 * @method static Builder|Mensagem whereTexto($value)
 * @method static Builder|Mensagem whereUpdatedAt($value)
 * @method static Builder|Mensagem whereAbertas()
 * @method static Builder|Mensagem whereFechadas()
 */
class Mensagem extends Entity
{
	public static $snakeAttributes = false;

	protected $table = 'mensagens';

	protected $casts = [
		'remetente_id' => 'int',
		'destinatario_id' => 'int',
		'aberto' => 'bool'
	];

	protected $fillable = [
		'remetente_id',
		'destinatario_id',
		'texto',
		'aberto'
	];

	const ABERTO = 1;
	const FECHADA = 0;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function remetente()
	{
		// TODO Remetente
        return $this->belongsTo(User::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destinatario()
    {
        // TODO Destinatario
        return $this->belongsTo(User::class);
    }

    public function scopeChat(Builder $query, $userOne, $userTwo)
    {
        return $query->where([['remetente_id', $userOne], ['destinatario_id', $userTwo]])
            ->orWhere([['remetente_id', $userTwo], ['destinatario_id', $userOne]]);
	}

    public function scopeWhereFechadas(Builder $query)
    {
        return $query->where("aberto", self::FECHADA);
	}

    public function scopeWhereAbertas(Builder $query)
    {
        return $query->where("aberto", self::ABERTO);
    }
}
