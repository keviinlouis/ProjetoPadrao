<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;


/**
 * App\Entities\Arquivo
 *
 * @property int $id
 * @property string $nome
 * @property string $extensao
 * @property int $tipo
 * @property string|null $path
 * @property string|null $descricao
 * @property int $entidade_id
 * @property string|null $entidade_type
 * @property string|null $url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $entidade
 * @property-read string $nome_com_extensao
 * @method static Builder|Arquivo whereCreatedAt($value)
 * @method static Builder|Arquivo whereDescricao($value)
 * @method static Builder|Arquivo whereEntidadeId($value)
 * @method static Builder|Arquivo whereEntidadeType($value)
 * @method static Builder|Arquivo whereExtensao($value)
 * @method static Builder|Arquivo whereId($value)
 * @method static Builder|Arquivo whereNome($value)
 * @method static Builder|Arquivo wherePath($value)
 * @method static Builder|Arquivo whereTipo($value)
 * @method static Builder|Arquivo whereUpdatedAt($value)
 * @method static Builder|Arquivo whereUrl($value)
 * @mixin \Eloquent
 */
class Arquivo extends Entity
{
    public static $snakeAttributes = false;

    protected $casts = [
        'tipo' => 'int',
        'entidade_id' => 'int'
    ];

    protected $fillable = [
        'nome',
        'extensao',
        'tipo',
        'path',
        'url',
        'descricao',
        'entidade_id',
        'entidade_type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entidade()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getNomeComExtensaoAttribute()
    {
        $extensao = str_replace('.', '', $this->extensao);
        return $this->nome.'.'.$extensao;
    }

    public function removeFile()
    {
        return \Storage::delete($this->path);
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function moveTo($path)
    {
        $this->checkDestinoExists($path);

        \Storage::move($this->path, $path.'/'.$this->nome_com_extensao);

        return $this;
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function copyTo($path)
    {
        $this->checkDestinoExists($path);

        \Storage::copy($this->path, $path.'/'.$this->nome_com_extensao);

        return $this;
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function checkDestinoExists($path)
    {
        if(!\Storage::exists($path)){
            \Storage::makeDirectory($path);
        }
    }
}
