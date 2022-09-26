<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    /** @var string */
    private string $statusSuccess = 'success';
    /** @var string */
    private string $statusError = 'error';

    /**
     * @param mixed $collection
     * @param LengthAwarePaginator $paginator
     * @return JsonResponse
     */
    public function responsePaginateSuccess(mixed $collection, LengthAwarePaginator $paginator): JsonResponse
    {
        return response()->json(
            [
                'status' => $this->statusSuccess,
                'data' => $collection->collection,
                'meta' => [
                    'currentPage' => $paginator->currentPage(),
                    'lastPage' => $paginator->lastPage(),
                    'path' => $paginator->path(),
                    'perPage' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ],
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     */
    public function responseSuccess(string $message, mixed $data = null): JsonResponse
    {
        $return = [
            'status' => $this->statusSuccess,
            'message' => $message,
        ];
        if (!is_null($data)) {
            $return['data'] = $data;
        }
        return response()->json($return, Response::HTTP_OK);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseError(string $message, int $statusCode = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json(
            [
                'status' => $this->statusError,
                'message' => $message,
            ],
            $statusCode
        );
    }
}
