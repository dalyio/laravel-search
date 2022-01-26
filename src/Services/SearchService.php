<?php

namespace Dalyio\Search\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SearchService
{
    /**
     * @param string $searchTerm
     * @return \Illuminate\Support\Collection
     */
    public function search($searchTerm, $namespace = 'default', $limit = null)
    {
        $results = [];
        
        if (!$limit) $limit = config('search.limit', 10);
        foreach (config('search.'.$namespace.'.models', []) as $modelClass) {
            $modelResults = $this->searchModel($modelClass, $searchTerm, $limit);
            if ($modelResults->isNotEmpty()) $results[$modelClass] = $modelResults;
        }
        
        return collect($results);
    }  
    
    protected function searchModel($modelClass, $searchTerm, $limit)
    {
        $searchTerm = $this->formatSearchTerm($searchTerm);
        $model = App::make($modelClass);
        
        // TODO: alternative for PHP 7.4 requirement
        $searchAttributes = (fn() => $this->searchable)->call($model);
        if (!$searchAttributes) $searchAttributes = Schema::getColumnListing($model->getTable());

        $results = $this->searchExactAndResults($searchTerm, $searchAttributes, $model);
        if ($results->isEmpty()) $results = $this->searchLikeAndResults($searchTerm, $searchAttributes, $model);
        if ($results->isEmpty()) $results = $this->searchExactOrResults($searchTerm, $searchAttributes, $model);
        if ($results->isEmpty()) $results = $this->searchLikeOrResults($searchTerm, $searchAttributes, $model);
        
        $resultIds = $results->unique()->pluck('id')->take($limit);
        return ($resultIds->isNotEmpty()) ? $modelClass::whereIn('id', $resultIds)->orderByRaw("FIELD(id, ".implode(',', $resultIds->toArray()).")")->get()->map(function($model) {
            return (method_exists($model, 'toSearch')) ? $model->toSearch() : $model->toArray();
        }) : collect([]);
    }
    
    protected function searchExactAndResults($searchTerm, $searchAttributes, $model)
    {
        $queryBuilder = DB::table($model->getTable());
        return $queryBuilder->whereNested(function($searchQuery) use($searchTerm, $searchAttributes) {
            $searchQuery->where(function($searchQuery) use($searchTerm, $searchAttributes) {
                foreach ($searchAttributes as $attribute) {
                    $searchQuery->where(function($searchQuery) use($searchTerm, $attribute) {
                        $searchTermSegments = $this->breakdownSearchTerm($searchTerm);                
                        foreach ($searchTermSegments as $searchTermSegment) {
                            $whereMethod = (empty($searchQuery->wheres)) ? 'where' : 'orWhere';
                            $searchQuery->{$whereMethod}($attribute, $searchTermSegment);
                        }
                    });
                }
            });
        })->get();
    }
    
    protected function searchLikeAndResults($searchTerm, $searchAttributes, $model)
    {
        $queryBuilder = DB::table($model->getTable());
        return $queryBuilder->whereNested(function($searchQuery) use($searchTerm, $searchAttributes) {
            $searchQuery->where(function($searchQuery) use($searchTerm, $searchAttributes) {
                foreach ($searchAttributes as $attribute) {
                    $searchQuery->where(function($searchQuery) use($searchTerm, $attribute) {
                        $searchTermSegments = $this->breakdownSearchTerm($searchTerm);
                        foreach ($searchTermSegments as $searchTermSegment) {
                            $whereMethod = (empty($searchQuery->wheres)) ? 'where' : 'orWhere';
                            $searchQuery->{$whereMethod}(DB::raw('lower('.$attribute.')'), 'like', '%'.strtolower($searchTermSegment).'%');
                        }
                    });
                }
            });
        })->get();
    }
    
    protected function searchExactOrResults($searchTerm, $searchAttributes, $model)
    {
        $queryBuilder = DB::table($model->getTable());
        return $queryBuilder->whereNested(function($searchQuery) use($searchTerm, $searchAttributes) {
            $searchQuery->where(function($searchQuery) use($searchTerm, $searchAttributes) {
                foreach ($searchAttributes as $attribute) {
                    $whereMethod = (empty($searchQuery->wheres)) ? 'where' : 'orWhere';
                    $searchQuery->{$whereMethod}(function($searchQuery) use($searchTerm, $attribute) {
                        $searchTermSegments = $this->breakdownSearchTerm($searchTerm);                
                        foreach ($searchTermSegments as $searchTermSegment) {
                            $whereMethod = (empty($searchQuery->wheres)) ? 'where' : 'orWhere';
                            $searchQuery->{$whereMethod}($attribute, $searchTermSegment);
                        }
                    });
                }
            });
        })->get();
    }
    
    protected function searchLikeOrResults($searchTerm, $searchAttributes, $model)
    {
        $queryBuilder = DB::table($model->getTable());
        return $queryBuilder->whereNested(function($searchQuery) use($searchTerm, $searchAttributes) {
            $searchQuery->where(function($searchQuery) use($searchTerm, $searchAttributes) {
                foreach ($searchAttributes as $attribute) {
                    $whereMethod = (empty($searchQuery->wheres)) ? 'where' : 'orWhere';
                    $searchQuery->{$whereMethod}(function($searchQuery) use($searchTerm, $attribute) {
                        $searchTermSegments = $this->breakdownSearchTerm($searchTerm);
                        foreach ($searchTermSegments as $searchTermSegment) {
                            $whereMethod = (empty($searchQuery->wheres)) ? 'where' : 'orWhere';
                            $searchQuery->{$whereMethod}(DB::raw('lower('.$attribute.')'), 'like', '%'.strtolower($searchTermSegment).'%');
                        }
                    });
                }
            });
        })->get();
    }
    
    protected function formatSearchTerm($searchTerm)
    {
        return trim(preg_replace('/\s+/', ' ', $searchTerm));
    }
    
    protected function breakdownSearchTerm($searchTerm)
    {
        return explode(' ', $searchTerm);
    }
}
