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

        return $resourceClass::collection($collection);
    }
}