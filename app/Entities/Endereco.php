<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 11:06:51 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;
use Jcf\Geocode\Exceptions\EmptyArgumentsException;
use Jcf\Geocode\Geocode;


class Endereco extends Eloquent
{
	public static $snakeAttributes = false;

	protected $casts = [
		'numero' => 'int',
		'entidade_id' => 'int',
        'latitude' => 'float',
        'longitude' => 'float'
	];

	protected $fillable = [
		'cep',
		'rua',
		'numero',
		'complemento',
		'bairro',
		'cidade',
		'estado',
		'pais',
		'latitude',
		'longitude',
		'entidade_id',
		'entidade_type'
	];

    public function entidade()
    {
        return $this->morphTo();
	}
    /**
     * @return string
     */
    public function getEnderecoCompletoAttribute()
    {
        $endereco = $this->rua . ', ' . $this->numero . ', ';
        if ($this->bairro) {
            $endereco .= $this->bairro . ', ';
        }
        $endereco .= $this->cidade . ', ' . $this->estado;


        return $endereco;
    }

    /**
     * @return bool
     */
    public function loadLatLong()
    {
        try {
            $response = Geocode::make()->address($this->endereco_completo);
            if (!$response) {
                return false;
            }
            $this->latitude =  $response->latitude();
            $this->longitude =  $response->longitude();

            return $this->save();
        } catch (EmptyArgumentsException $e) {
            return false;
        }
    }
}
