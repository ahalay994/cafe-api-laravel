<?php

namespace App\DataTransferObjects;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\HttpFoundation\Response;

class ResponsePaginationData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var LengthAwarePaginator */
    public LengthAwarePaginator $paginator;

    /** @var mixed */
    public mixed $collection;

    public function toResponse($request): JsonResponse|Response
    {
        return $this->responsePaginateSuccess($this->collection, $this->paginator);
    }
}
