<?php

namespace App\DataTransferObjects\Position\Relations;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @property-read PositionObject $collection
 */
class PositionResponseObject extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var PositionObject */
    #[CastWith(PositionObjectCaster::class)]
    public PositionObject $collection;

    /**
     * @param $request
     * @return PositionObject
     */
    public function toResponse($request): PositionObject
    {
        return $this->collection;
    }
}
