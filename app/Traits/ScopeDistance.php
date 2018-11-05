<?php
/**
 * Created by PhpStorm.
 * User: devmaker
 * Date: 14/08/18
 * Time: 13:14
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait ScopeDistance
{
    public $fieldDistance = 'distancia';
    public $tableRelated = 'enderecos';

    public function scopeWhereMorphDistance(
        Builder $query,
        float $latitude,
        float $longitude,
        float $raio,
        \Closure $where = null
    ) {

        $query->selectRaw($this->getTable() . ".*, " . $this->buildSqlString($latitude, $longitude, $this->tableRelated, self::getDistanceField()));

        $query->from($this->getTable());

        $query->join($this->tableRelated, $this->tableRelated . '.entidade_id', '=',
            $this->getTable() . '.' . $this->getKeyName());

        $query->where($this->tableRelated . '.entidade_type', '=', get_class($this));

        if ($where) {
            $query->where($where);
        }

        $query->whereRaw($this->buildSqlString($latitude, $longitude, $this->tableRelated)." <= ".$this->clearStringLatLong($raio));

    }

    public static function getDistanceField()
    {
        return (new self())->fieldDistance;
    }

    public function scopeWhereDistance(
        Builder $query,
        float $latitude,
        float $longitude,
        float $raio,
        \Closure $where = null)
    {
        $query->selectRaw($this->getTable() . ".*, " . $this->buildSqlString($latitude, $longitude, $this->getTable(), self::getDistanceField()));

        $query->from($this->getTable());

        if ($where) {
            $query->where($where);
        }

        $query->whereRaw($this->buildSqlString($latitude, $longitude, $this->getTable())." <= ".$this->clearStringLatLong($raio));

    }

    private function clearStringLatLong($string)
    {
        return str_replace(',', '.', $string);
    }

    private function buildSqlString($latitude, $longitude, $table, string $as = '')
    {

        $latitude = $this->clearStringLatLong($latitude);
        $longitude = $this->clearStringLatLong($longitude);

        $calc = $this->clearStringLatLong((string) 1.853159616);

        $sql = "((ACOS(SIN({$latitude} * PI() / 180) * SIN({$table}.latitude * PI() / 180) +
                COS({$latitude} * PI() / 180) * COS({$table}.latitude * PI() / 180) *
            COS(({$longitude} - {$table}.longitude) * PI() / 180)) * 180 / PI()) * 60 * {$calc})";

        if(strlen($as)){
            $sql .= " as {$as}";
        }

        return $sql;
    }
}
