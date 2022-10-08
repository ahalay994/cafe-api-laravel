<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Addition\AdditionResponseData;
use App\DataTransferObjects\Addition\AdditionsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionRequest;
use App\Models\Addition;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdditionController extends Controller
{
    protected $model = Addition::class;
    protected $translatePath = 'controller.addition';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $additions = $this->model::paginate();

        return new ResponsePaginationData([
            'paginator' => $additions,
            'collection' => new AdditionsCollection(['collection' => $additions->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AdditionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): AdditionResponseData|NotFoundHttpException
    {
        try {
            $additions = $this->model::findOrFail($id);

            return new AdditionResponseData(['additions' => $additions, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AdditionRequest $request
     * @return AdditionResponseData
     * @throws UnknownProperties
     */
    public function create(AdditionRequest $request): AdditionResponseData
    {
        $addition = $this->model::create($request->all());

        return new AdditionResponseData(['addition' => $addition, 'message' => __($this->translatePath . '.create')]);
    }

    /**
     * @param AdditionRequest $request
     * @param int $id
     * @return AdditionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AdditionRequest $request, int $id): AdditionResponseData|NotFoundHttpException
    {
        try {
            /** @var Addition $addition */
            $addition = $this->model::findOrFail($id);
            $addition->name = $request->name ?? $addition->name;
            $addition->slug = $request->slug ?? $addition->slug;
            $addition->description = $request->description ?? $addition->description;
            $addition->image = $request->image ?? $addition->image;
            $addition->price = $request->price ?? $addition->price;
            $addition->discount = $request->discount ?? $addition->discount;
            $addition->save();

            return new AdditionResponseData(['addition' => $addition, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
