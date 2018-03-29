<?php

namespace App\Traits;

trait Files
{
    public function getPublicPathFiles()
    {
        return 'public/'.$this->getTable().'/'.$this->getKey();
    }

    public function removePublicFiles()
    {
       !\Storage::exists($this->getPublicPathFiles())?:\Storage::deleteDirectory($this->getPublicPathFiles());
    }

    public function getPathFiles()
    {
        return $this->getTable().'/'.$this->getKey();
    }

    public function removeFiles()
    {
        !\Storage::exists($this->getPathFiles())?:\Storage::deleteDirectory($this->getPathFiles());
    }
}