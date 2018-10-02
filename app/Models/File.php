<?php
namespace App\Entities;

use App\Models\BaseModel;


class File extends BaseModel
{
    const TYPES_IMAGE = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    const THUMB_PREFIX = 'thumb_';
    const SIZE_SMALL = 'S';
    const SIZE_ORIGINAL = 'O';
    const THUMB_WIDTH = 256;
    const THUMB_HEIGHT = 256;

    public static $snakeAttributes = false;


    protected $casts = [
        'tipo' => 'int',
        'entidade_id' => 'int'
    ];
    protected $fillable = [
        'name',
        'extension',
        'type',
        'path',
        'url',
        'description',
        'model_id',
        'model_type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
    public function getUrlThumbAttribute(): string
    {
        $url = explode('/', $this->url);
        $thumb = self::THUMB_PREFIX.end($url);
        $url[count($url)-1] = $thumb;
        $urlThumb = implode('/', $url);
        return $urlThumb;
    }
    public function getPathThumbAttribute(): string
    {
        $path = explode('/', $this->path);
        $thumb = self::THUMB_PREFIX.end($path);
        $path[count($path)-1] = $thumb;
        $pathThumb = implode('/', $path);
        return $pathThumb;
    }
    /**
     * @return string
     */
    public function getNameWithExtensionAttribute()
    {
        $extensao = str_replace('.', '', $this->extension);
        return $this->nome.'.'.$extensao;
    }
    public function getPathWithoutNameAttribute()
    {
        return str_replace($this->nome, '', $this->path);
    }
    public function getNameThumbAttribute()
    {
        return self::THUMB_PREFIX.$this->name;
    }
    public function hasThumb()
    {
        return \Storage::exists($this->pathThumb);
    }
    public function removeFile()
    {
        return \Storage::delete($this->path);
    }
    public function removeThumb()
    {
        return $this->hasThumb() && \Storage::delete($this->pathThumb);
    }
    /**
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function moveTo($path)
    {
        $this->checkDestinoExists($path);
        \Storage::move($this->path, $path.'/'.$this->name_with_extension);
        return $this;
    }
    /**
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function copyTo($path)
    {
        $this->checkDestinoExists($path);
        \Storage::copy($this->path, $path.'/'.$this->name_with_extension);
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
    public function isImage()
    {
        return in_array($this->extension, self::TYPES_IMAGE) !== false;
    }
}
