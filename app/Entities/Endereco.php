<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 11:06:51 -0300.
 */

namespace App\Entities;

use App\Entities\Entity as Eloquent;
use Illuminate\Http\Response;
use Jcf\Geocode\Exceptions\EmptyArgumentsException;
use Jcf\Geocode\Geocode;
use Malhal\Geographical\Geographical;

/**
 * Class Endereco
 *
 * @property int $id
 * @property string $cep
 * @property string $rua
 * @property int $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cidade
 * @property string $estado
 * @property string $pais
 * @property float $latitude
 * @property float $longitude
 * @property int $entidade_id
 * @property string $entidade_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @package App\Entities
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereComplemento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereEntidadeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereEntidadeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco wherePais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereRua($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Endereco whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read string $endereco_completo
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $entidade
 */
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
        return $this->morphTo('entidade');
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

    public function hasDadosEnderecos()
    {
        return $this->rua && $this->numero && $this->cidade && $this->estado;
    }

    public function hasLatLong()
    {
        return $this->latitude && $this->longitude;
    }

    /**
     * @return Endereco|bool
     */
    public function loadLatLong()
    {
        try {
            $response = Geocode::make()->address($this->endereco_completo);
            if ($response) {
                $this->latitude = $response->latitude();
                $this->longitude = $response->longitude();
            }
        } catch (EmptyArgumentsException $e) {
        }
        return $this;
    }
    public function updateEnderecoByLatLong()
    {
        try {
            $endereco = \Geocode::make()->latLng($this->latitude, $this->longitude);
            if(!$endereco){
                return;
            }
            $data = Endereco::getDataEnderecoByGeocodeResponse($endereco->response);
            $data['latitude'] = $this->latitude;
            $data['longitude'] = $this->longitude;
            $this->fill($data);
            $this->save();
        } catch (\Exception $e){
        }
    }

    static public function getDataEnderecoByGeocodeResponse($response)
    {
        $data = [
            'cep' => Endereco::findFieldInGeocodeResponse($response, 'cep'),
            'rua' => Endereco::findFieldInGeocodeResponse($response, 'rua', true),
            'numero' => Endereco::findFieldInGeocodeResponse($response, 'numero'),
            'bairro' => Endereco::findFieldInGeocodeResponse($response, 'bairro', true),
            'cidade' => Endereco::findFieldInGeocodeResponse($response, 'cidade', true),
            'estado' => Endereco::findFieldInGeocodeResponse($response, 'estado', false),
            'pais' => Endereco::findFieldInGeocodeResponse($response, 'pais', false),
        ];

        return $data;
    }

    static public function findFieldInGeocodeResponse($response, $field, $longName = false)
    {
        foreach($response->address_components as $component){
            foreach($component->types as $type){
                if($type == Endereco::guessField($field)){
                    return $longName? $component->long_name : $component->short_name;
                }
            }
        }
        return null;
    }

    static public function guessField($field){
        switch($field){
            case 'rua':
            case 'street':
            case 'route':
                return 'route';

            case 'street_number':
            case 'numero':
                return 'street_number';

            case 'cidade':
            case 'administrative_area_level_2':
                return 'administrative_area_level_2';

            case 'estado':
            case 'uf':
            case 'administrative_area_level_1':
                return 'administrative_area_level_1';

            case 'bairro':
            case 'sublocality_level_1':
                return 'sublocality_level_1';

            case 'postal_code':
            case 'cep':
            case 'zip_code':
            case 'zipecode':
                return 'postal_code';

            case 'country':
            case 'pais':
                return 'country';
            default:
                return '';
        }
    }
}
