<?php

namespace App\LetzteMeile\Hotel\Database\Core;

use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Database\Eloquent\Model;
use App\Search\Contracts\SearchClientResponse;
use App\Search\Database\Contracts\BaseSearchResponse as BaseSearchResponseContract;
use App\Search\Database\Core\BaseSearchResponse;

class SearchResponse extends BaseSearchResponse implements BaseSearchResponseContract {

    /**
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     *
     * @param  SearchClientResponse  $response;
     * @param  Model  $model
     */
    public function __construct(SearchClientResponse $response, Model $model)
    {
        parent::__construct($response);
        $this->model = $model;
    }

    /**
     * Convert response values to entities.
     *
     * @return BaseCollection
     */
    protected function entitiesFromResponseValues()
    {
        $keyName = $this->model->getKeyName();
        $ids = $this->response()->ids();
        $entities = $this->model->whereIn($keyName, $ids)->get()->keyBy($keyName);
        $orderedEntities = new BaseCollection();
        foreach ($ids as $id)
        {
            if ($entities->has($id))
            {
                $orderedEntities->push($entities[$id]);
            }
        }
        return $orderedEntities;
    }

    /**
     * Retrieve results
     *
     * @return BaseCollection
     */
    public function values()
    {
        return $this->entitiesFromResponseValues();
    }

}