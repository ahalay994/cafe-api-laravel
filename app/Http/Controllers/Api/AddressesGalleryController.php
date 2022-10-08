<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\AddressesGallery\AddressesGalleriesCollection;
use App\DataTransferObjects\AddressesGallery\AddressesGalleryResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressesGalleryRequest;
use App\Models\AddressesGallery;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressesGalleryController extends Controller
{
    protected $model = AddressesGallery::class;
    protected $translatePath = 'controller.addressesGallery';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $addressesGalleries = $this->model::orderBy('sort', SORT_ASC)->paginate();

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
            $addressesGallery = $this->model::findOrFail($id);

            return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $addressesGallery = $this->model::create($request->all());
        $addressesGallery = $this->model::find($addressesGallery->id);

        return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => __($this->translatePath . '.create')]);
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
            /** @var AddressesGallery $addressesGallery */
            $addressesGallery = $this->model::findOrFail($id);
            $addressesGallery->address_id = $request->address_id ?? $addressesGallery->address_id;
            $addressesGallery->image = $request->image ?? $addressesGallery->image;
            $addressesGallery->sort = $request->sort ?? $addressesGallery->sort;
            $addressesGallery->save();

            return new AddressesGalleryResponseData(['addressesGallery' => $addressesGallery, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
