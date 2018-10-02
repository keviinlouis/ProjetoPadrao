<?php
/**
 * Created by Reliese Model.
 * Date: Wed, 11 Apr 2018 11:06:51 -0300.
 */

namespace App\Models;

use App\Models\BaseModel as Eloquent;
use Jcf\Geocode\Exceptions\EmptyArgumentsException;
use Jcf\Geocode\Geocode;


class Address extends Eloquent
{
    public static $snakeAttributes = false;
    protected $casts = [
        'number' => 'int',
        'modele_id' => 'int',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
    protected $fillable = [
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'model_id',
        'model_type',
    ];

    public function model()
    {
        return $this->morphTo('model');
    }

    public function getZipCodeDisplayAttribute()
    {
        return $this->makeMaskZipCode($this->zipCode);
    }

    /**
     * @return string
     */
    public function getFullAddressDisplayAttribute()
    {
        $endereco = $this->street . ', ' . $this->number . ', ';
        if ($this->neighborhood) {
            $endereco .= $this->neighborhood . ', ';
        }
        $endereco .= $this->city . ', ' . $this->state;
        return $endereco;
    }

    public function hasDadosAddresss()
    {
        return $this->street && $this->number && $this->city && $this->state;
    }

    public function hasLatLong()
    {
        return $this->latitude && $this->longitude;
    }

    /**
     * @return self|bool
     */
    public function loadLatLong()
    {
        try {
            $response = Geocode::make()->address($this->full_address_display);
            if ($response) {
                $this->latitude = $response->latitude();
                $this->longitude = $response->longitude();
                $this->updateAddressByLatLong();
            }
        } catch (EmptyArgumentsException $e) {
            \Log::channel('geocode')->error(
                'Can\' find latlong by address',
                ['full_address' => $this->full_address_display]
            );
        }
        return $this;
    }

    public function updateAddressByLatLong()
    {
        try {
            $endereco = Geocode::make()->latLng($this->latitude, $this->longitude);
            if (!$endereco) {
                throw new \Exception();
            }
            $data = self::getDataAddressByGeocodeResponse($endereco->response);
            $data['latitude'] = $this->latitude;
            $data['longitude'] = $this->longitude;
            $this->fill($data);
            $this->save();
        } catch (\Exception $e) {
            \Log::channel('geocode')->error(
                'Can\' find address by latlong',
                [
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]
            );
        }
    }

    static public function getDataAddressByGeocodeResponse($response)
    {
        $data = [
            'zip_code' => self::findFieldInGeocodeResponse($response, 'zip_code'),
            'street' => self::findFieldInGeocodeResponse($response, 'street', true),
            'number' => self::findFieldInGeocodeResponse($response, 'number'),
            'neighborhood' => self::findFieldInGeocodeResponse($response, 'neighborhood', true),
            'city' => self::findFieldInGeocodeResponse($response, 'city', true),
            'state' => self::findFieldInGeocodeResponse($response, 'state', false),
            'country' => self::findFieldInGeocodeResponse($response, 'country', false),
        ];
        return $data;
    }

    static public function findFieldInGeocodeResponse($response, $field, $longName = false)
    {
        foreach ($response->address_components as $component) {
            foreach ($component->types as $type) {
                if ($type == self::guessField($field)) {
                    return $longName ? $component->long_name : $component->short_name;
                }
            }
        }
        return null;
    }

    static public function guessField($field)
    {
        switch ($field) {
            case 'rua':
            case 'street':
            case 'route':
                return 'route';
            case 'street_number':
            case 'numero':
            case 'number':
                return 'street_number';
            case 'cidade':
            case 'city':
            case 'administrative_area_level_2':
                return 'administrative_area_level_2';
            case 'estado':
            case 'uf':
            case 'state':
            case 'administrative_area_level_1':
                return 'administrative_area_level_1';
            case 'bairro':
            case 'neighborhood':
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
