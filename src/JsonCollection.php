<?php


namespace marhone\Transformer;


use Illuminate\Http\Resources\CollectsResources;
use IteratorAggregate;

class JsonCollection extends JsonResource implements IteratorAggregate
{
    use CollectsResources;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $collection;

    public $collects;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
    }

    public function toArray()
    {
        return $this->collection->map->toArray()->all();
    }
}