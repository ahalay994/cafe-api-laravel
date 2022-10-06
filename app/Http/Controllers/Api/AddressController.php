<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Address\AddressesCollection;
use App\DataTransferObjects\Address\AddressResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $addresses = Address::paginate();

        return new ResponsePaginationData([
            'paginator' => $addresses,
            'collection' => new AddressesCollection(['collection' => $addresses->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AddressResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): AddressResponseData|NotFoundHttpException
    {
        try {
            $address = Address::findOrFail($id);

            return new AddressResponseData(['address' => $address, 'message' => __('controller.address.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AddressRequest $request
     * @return AddressResponseData
     * @throws UnknownProperties
     */
    public function create(AddressRequest $request): AddressResponseData
    {
        $address = Address::create($request->all());

        return new AddressResponseData(['address' => $address, 'message' => __('controller.address.create')]);
    }

    /**
     * @param AddressRequest $request
     * @param int $id
     * @return AddressResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AddressRequest $request, int $id): AddressResponseData|NotFoundHttpException
    {
        try {
            $address = Address::findOrFail($id);
            $address->name = $request->name ?? $address->name;
            $address->description = $request->description ?? $address->description;
            $address->lat = $request->lat ?? $address->lat;
            $address->lon = $request->lon ?? $address->lon;
            $address->save();

            return new AddressResponseData(['address' => $address, 'message' => __('controller.address.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): JsonResponse|NotFoundHttpException
    {
        try {
            Address::destroy($id);

            return $this->responseSuccess(__('controller.address.delete', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function restore(int $id): JsonResponse|NotFoundHttpException
    {
        try {
            Address::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.address.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
