<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Address\AddressesCollection;
use App\DataTransferObjects\Address\AddressResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressController extends Controller
{
    protected $model = Address::class;
    protected $translatePath = 'controller.address';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $addresses = $this->model::paginate();

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
            $address = $this->model::findOrFail($id);

            return new AddressResponseData(['address' => $address, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $address = $this->model::create($request->all());

        return new AddressResponseData(['address' => $address, 'message' => __($this->translatePath . '.create')]);
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
            /** @var Address $address */
            $address = $this->model::findOrFail($id);
            $address->name = $request->name ?? $address->name;
            $address->description = $request->description ?? $address->description;
            $address->lat = $request->lat ?? $address->lat;
            $address->lon = $request->lon ?? $address->lon;
            $address->save();

            return new AddressResponseData(['address' => $address, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
