<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Partner\PartnerResponseData;
use App\DataTransferObjects\Partner\PartnersCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartnerController extends Controller
{
    protected $model = Partner::class;
    protected $translatePath = 'controller.partner';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $partners = $this->model::paginate();

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
            $partner = $this->model::findOrFail($id);

            return new PartnerResponseData(['partner' => $partner, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $partner = $this->model::create($request->all());

        return new PartnerResponseData(['partner' => $partner, 'message' => __($this->translatePath . '.create')]);
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
            /** @var Partner $partner */
            $partner = $this->model::findOrFail($id);
            $partner->name = $request->name ?? $partner->name;
            $partner->image = $request->image ?? $partner->image;
            $partner->save();

            return new PartnerResponseData(['partner' => $partner, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
