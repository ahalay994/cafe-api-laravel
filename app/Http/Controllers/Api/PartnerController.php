<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Partner\PartnerResponseData;
use App\DataTransferObjects\Partner\PartnersCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartnerController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $partners = Partner::paginate();

        return new ResponsePaginationData([
            'paginator' => $partners,
            'collection' => new PartnersCollection(['collection' => $partners->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return PartnerResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): NotFoundHttpException|PartnerResponseData
    {
        try {
            $partner = Partner::findOrFail($id);

            return new PartnerResponseData(['partner' => $partner, 'message' => __('controller.partner.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param PartnerRequest $request
     * @return PartnerResponseData
     * @throws UnknownProperties
     */
    public function create(PartnerRequest $request): PartnerResponseData
    {
        $partner = Partner::create($request->all());

        return new PartnerResponseData(['partner' => $partner, 'message' => __('controller.partner.create')]);
    }

    /**
     * @param PartnerRequest $request
     * @param int $id
     * @return PartnerResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(PartnerRequest $request, int $id): NotFoundHttpException|PartnerResponseData
    {
        try {
            $partner = Partner::findOrFail($id);
            $partner->name = $request->name ?? $partner->name;
            $partner->image = $request->image ?? $partner->image;
            $partner->save();

            return new PartnerResponseData(['partner' => $partner, 'message' => __('controller.partner.update', ['id' => $id])]);
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
            Partner::destroy($id);

            return $this->responseSuccess(__('controller.partner.delete', ['id' => $id]));
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
            Partner::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.partner.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
