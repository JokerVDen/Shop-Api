<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TransformResourceInput
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $resourceClass
     * @return mixed
     */
    public function handle($request, Closure $next, string $resourceClass)
    {
        $transformedInput = [];
        foreach ($request->request->all() as $input => $value) {
            $transformedInput[$resourceClass::originalAttribute($input)] = $value;
        }
        $request->replace($transformedInput);

        /** @var JsonResponse $response */
        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();

            $transformedErrors = [];
            foreach ($data->errors as $field => $error) {
                $transformedField = $resourceClass::transformedAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }

            $data->errors = $transformedErrors;

            $response->setData($data);
        }

        return $response;
    }
}
