<?php

namespace App\Vuetable\Builders;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentVuetableBuilder
{

    /**
     * The current request.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Query used to make the table data.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $query;

    /**
     * Array of columns that should be added and the new content.
     *
     * @var array
     */
    private $columnsToAdd = [];


    public function __construct(Request $request, $query)
    {
        request()->only(['itemsPerPage', 'page', 'sortBy', 'sortDesc', 'query']);
        $this->request = $request;
        $this->query = $query;
    }

    public function make()
    {
        $query = $this->request->input('query');
        $itemsPerPage = $this->request->input('itemsPerPage');
        $page = $this->request->input('page');
        $sortBy = $this->request->input('sortBy');
        $sortDesc = $this->request->input('sortDesc');

        $data = $this->query;

        if (isset($query) && $query) {
            $this->filterByColumn($data, $query);
        }

        $count = $data->count();
        $data->take($itemsPerPage)
            ->skip($itemsPerPage * ($page - 1));

        if (isset($sortBy) && count($sortBy) > 0) {
            $direction = $sortDesc[0] == 1 ? 'ASC' : 'DESC';
            $data->orderBy($sortBy[0], $direction);
        }

        $results = $data->get();
        $this->applyChangesTo($results);

        return [
            'data' => $results,
            'count' => $count,
        ];
    }

    /**
     * Add filter by column.
     *
     * @param  $data, \Illuminate\Database\Eloquent\Model $query
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function filterByColumn($data, $queries)
    {
        return $data->where(function ($q) use ($queries) {
            foreach ($queries as $field => $query) {
                if (is_string($query)) {
                    $q->where($field, 'LIKE', "%{$query}%");
                } else {
                    $start = Carbon::createFromFormat('Y-m-d', $query['start'])->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d', $query['end'])->endOfDay();

                    $q->whereBetween($field, [$start, $end]);
                }
            }
        });
    }

    /**
     * Add a new column to the columns to add.
     *
     * @param string $column
     * @param string|Closure $content
     */
    public function addColumn($column, $content)
    {
        $this->columnsToAdd[$column] = $content;

        return $this;
    }

    /**
     * Edit the results inside the pagination object.
     *
     * @param  \Illuminate\Pagination\LengthAwarePaginator $results
     * @param  array $columnsToEdit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function applyChangesTo($results)
    {
        if (empty($this->columnsToAdd)) {
            return $results;
        }

        if ($results instanceof LengthAwarePaginator) {
            $newData = $results->getCollection();
            return $results->setCollection($this->editData($newData));
        } else if ($results instanceof Collection) {
            return $this->editData($results);
        } else {
            throw new Exception('invalid results object');
        }
    }

    /**
     * edits the $data fetched from the database 
     * @param  collection $data
     * @return Collection
     */
    public function editData($data)
    {
        return $data->map(function ($model) {
            $model = $this->addModelAttibutes($model);
            return $model;
        });
    }

    /**
     * Add the model attributes acording to the columnsToAdd attribute.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function addModelAttibutes($model)
    {
        foreach ($this->columnsToAdd as $column => $value) {
            if ($model->relationLoaded($column) || $model->getAttributeValue($column) != null) {
                throw new \Exception("Can not add the '{$column}' column, the results already have that column.");
            }

            $model = $this->changeAttribute($model, $column, $value);
        }

        return $model;
    }

    /**
     * Change a model attribe
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $attribute
     * @param  string|Closure $value
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function changeAttribute($model, $attribute, $value)
    {
        if ($value instanceof Closure) {
            $model->setAttribute($attribute, $value($model));
        } else {
            $model->setAttribute($attribute, $value);
        }

        if ($model->relationLoaded($attribute)) {
            $model->setRelation($attribute, 'removed');
        }

        return $model;
    }
}
