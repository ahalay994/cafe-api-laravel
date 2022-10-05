<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\AddressesGallery\AddressesGalleriesCollection;
use App\DataTransferObjects\AddressesGallery\AddressesGalleryResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressesGalleryRequest;
use App\Models\AddressesGallery;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressesGalleryController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $addressesGalleries = AddressesGallery::paginate();

        return new ResponsePaginationData([
            'paginator' => $addressesGalleries,
            'collection' => new AddressesGalleriesCollection(['collection' => $addressesGalleries->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AddressesGalleryResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): AddressesGalleryResponseData|NotFoundHttpException
    {
        try {
            $addressesGallery = AddressesGallery::findOrFail($id);
            return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => 'Контактные данные адреса #' . $id . ' успешно получены']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AddressesGalleryRequest $request
     * @return AddressesGalleryResponseData
     * @throws UnknownProperties
     */
    public function create(AddressesGalleryRequest $request): AddressesGalleryResponseData
    {
        $addressesGallery = AddressesGallery::create($request->all());
        $addressesGallery = AddressesGallery::find($addressesGallery->id);

        return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => 'Контактные данные адреса успешно созданы']);
    }

    /**
     * @param AddressesGalleryRequest $request
     * @param int $id
     * @return AddressesGalleryResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AddressesGalleryRequest $request, int $id): NotFoundHttpException|AddressesGalleryResponseData
    {
        try {
            $addressesGallery = AddressesGallery::findOrFail($id);
            $addressesGallery->address_id = $request->address_id ?? $addressesGallery->address_id;
            $addressesGallery->image = $request->image ?? $addressesGallery->image;
            $addressesGallery->save();

            return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => 'Контактные данные адреса успешно обновлены']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): NotFoundHttpException|JsonResponse
    {
        try {
            AddressesGallery::findOrFail($id)->delete();

            return $this->responseSuccess('Контактные данные адреса успешно удалены');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return NotFoundHttpException|JsonResponse
     */
    public function restore(int $id): NotFoundHttpException|JsonResponse
    {
        try {
            AddressesGallery::withTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess('Контактные данные адреса успешно восстановлены');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
