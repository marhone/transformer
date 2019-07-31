<?php


namespace marhone\Transformer;


use ArrayAccess;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\DelegatesToResource;
use Illuminate\Support\Collection;
use JsonSerializable;

class JsonResource implements ArrayAccess, JsonSerializable
{
    use ConditionallyLoadsAttributes, DelegatesToResource;

    /**
     * @var mixed
     */
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    public function toArray()
    {
        return $this->resource->toArray();
    }

    public function jsonSerialize()
    {
        if($this->resource instanceof LengthAwarePaginator) {
             return [
                 'page' => $this->resource->currentPage(),
                 'page_size' => $this->resource->perPage(),
                 'total_page' => $this->resource->lastPage(),
                 'total_record' => $this->resource->total(),
                 'list' => $this->filter($this->toArray()),
             ];
        }

        if ($this->resource instanceof Collection) {
            return [
                'total_record' => $this->resource->count(),
                'list' => $this->filter($this->toArray())
            ];
        }

        return [
            'entity' => $this->filter($this->toArray())
        ];
    }
}
