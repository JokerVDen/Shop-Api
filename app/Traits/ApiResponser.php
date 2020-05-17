<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

trait ApiResponser
{
    /**
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function successResponse($data, int $code)
    {
        return response()->json($data, $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, int $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * @param Collection $collection
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        return $this->successResponse([
            'data' => $this->toResourceCollection($collection)
        ], $code);
    }

    /**
     * @param $model
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonOne(Model $model, $code = 200)
    {
        return $this->successResponse([
            'data' => $this->toResource($model)
        ], $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showMessage($message, int $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    /**
     * @param Model $model
     * @return JsonResource
     */
    protected function toResource(Model $model): JsonResource
    {
        $resourceClass = $model->resourceClass;

        return new $resourceClass($model);
    }

    /**
     * @param Collection $collection
     * @return JsonResource
     */

    protected function toResourceCollection(Collection $collection): JsonResource
    {
        $resourceClass = $collection->first()->resourceClass;
        $collection = $this->filterData($collection, $resourceClass);
        $collection = $this->sortData($collection, $resourceClass);

        return $resourceClass::collection($collection);
    }

    /**
     * @param Collection $collection
     * @param string $resourceClass
     * @return Collection|mixed
     */
    protected function sortData(Collection $collection, string $resourceClass)
    {
        if (request()->has('sort_by')) {
            $attribute = $resourceClass::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    /**
     * @param Collection $collection
     * @param string $resourceClass
     * @return Collection
     */
    protected function filterData(Collection $collection, string $resourceClass): Collection
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $resourceClass::originalAttribute($query);

            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }
}