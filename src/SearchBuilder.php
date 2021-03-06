<?php

namespace Devpoint\SearchClient\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Devpoint\SearchClient\Contracts\SearchClientResponse;
use Devpoint\SearchClient\Database\Contracts\BaseSearchBuilder as BaseSearchBuilderContract;
use Devpoint\SearchClient\Database\Core\BaseSearchBuilder;

class SearchBuilder extends BaseSearchBuilder implements BaseSearchBuilderContract {

    /**
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     *
     * @param  SearchClientBuilder  $builder
     * @param  Model  $model
     */
    public function __construct(
                            SearchClientBuilder $builder, 
                            Model $model)
    {
        parent::__construct($builder);
        $this->model = $model;
    }

    /**
     * Create new response instance.
     *
     * @param  SearchClientResponse  $response
     * @return SearchResponse
     */
    protected function newResponseInstance(SearchClientResponse $response)
    {
        return new SearchResponse($response, $this->model);
    }

    /**
     * Perform paginated search
     *
     * @param  int    $page
     * @param  int    $pageSize
     * @return SearchResponse
     */
    public function paginate($page, $pageSize)
    {
        return $this->newResponseInstance($this->builder->paginate($page, $pageSize));
    }

    /**
     * Perform search
     *
     * @return SearchResponse
     */
    public function get()
    {
        return $this->newResponseInstance($this->builder->get());
    }
    
}