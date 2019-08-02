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

    protected $wrapperNeed = true;

    public function __construct($resource)
    {
        $this->resource = $this->collectResource($resource);
    }

    public function withoutWrapper()
    {
        $this->wrapperNeed = false;
        return $this;
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
        $filtered = $this->filter($this->toArray());
        if (!$this->wrapperNeed) {
            return $filtered;
        }
        if($this->resource instanceof LengthAwarePaginator) {
             return [
                 'page' => $this->resource->currentPage(),
                 'page_size' => $this->resource->perPage(),
                 'total_page' => $this->resource->lastPage(),
                 'total_record' => $this->resource->total(),
                 'list' => $filtered,
             ];
        }

        if ($this->resource instanceof Collection) {
            return [
                'total_record' => $this->resource->count(),
                'list' => $filtered
            ];
        }

        return [
            'entity' => $filtered
        ];
    }
}
