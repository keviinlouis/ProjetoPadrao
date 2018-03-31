<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Resource extends JsonResource
{
    private $isCollection;

    /**
     * Resource constructor.
     * @param $resource Collection|LengthAwarePaginator|Model|Model[]
     */
    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->isCollection = ($resource instanceof Collection || $resource instanceof LengthAwarePaginator);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public final function toArray($request)
    {
        return $this->isCollection ? $this->toCollection($this->resource) : $this->toResource($this->resource);
    }

    public function with($request)
    {
        $response = [
            'success' => true
        ];

        if ($this->resource instanceof LengthAwarePaginator) {
            $response = $this->extractPaginator($response);
        }


        return $response;
    }

    /**
     * @param Collection|LengthAwarePaginator $collection
     * @return array
     */
    public function toCollection($collection)
    {
        return $collection->map(function ($resource) {
            return $this->toItemOfCollection($resource);
        })->toArray();
    }

    /**
     * @param Model $resource
     * @return array
     */
    public function toItemOfCollection($resource)
    {
        return $this->toResource($resource);
    }

    /**
     * @param Model $resource
     * @return array
     */
    abstract public function toResource($resource);


    public function extractPaginator($response)
    {
        $paginator = (object) $this->resource->toArray();

        $response['links'] = [
            'first_page_url' => $paginator->first_page_url,
            'last_page_url' => $paginator->last_page_url,
            'next_page_url' => $paginator->next_page_url,
            'prev_page_url' => $paginator->prev_page_url
        ];

        $response['meta'] = [
            'current_page' => $paginator->current_page,
            'from' => $paginator->from,
            'last_page' => $paginator->last_page,
            'path' => $paginator->path,
            'per_page' => $paginator->per_page,
            'to' => $paginator->to,
            'total' => $paginator->total
        ];

        return $response;
    }
}
