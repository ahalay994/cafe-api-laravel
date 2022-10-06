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
        $addressesGalleries = AddressesGallery::orderBy('sort', SORT_ASC)->paginate();

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

            return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => __('controller.addressesGallery.show', ['id' => $id])]);
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

        return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => __('controller.addressesGallery.create')]);
    }

    /**
     * @param AddressesGalleryRequest $request
     * @param int $id
     * @return AddressesGalleryResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AddressesGalleryRequest $request, int $id): AddressesGalleryResponseData|NotFoundHttpException
    {
        try {
            $addressesGallery = AddressesGallery::findOrFail($id);
            $addressesGallery->address_id = $request->address_id ?? $addressesGallery->address_id;
            $addressesGallery->image = $request->image ?? $addressesGallery->image;
            $addressesGallery->sort = $request->sort ?? $addressesGallery->sort;
            $addressesGallery->save();

            return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => __('controller.addressesGallery.update', ['id' => $id])]);
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
            AddressesGallery::destroy($id);

            return $this->responseSuccess(__('controller.addressesGallery.delete', ['id' => $id]));
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
            AddressesGallery::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.addressesGallery.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
