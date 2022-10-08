<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Product\ProductResponseData;
use App\DataTransferObjects\Product\ProductsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductsAdditionRequest;
use App\Http\Requests\ProductsPositionRequest;
use App\Http\Requests\ProductsTagRequest;
use App\Models\Addition;
use App\Models\Position;
use App\Models\Product;
use App\Models\ProductsAddition;
use App\Models\ProductsPosition;
use App\Models\ProductsTag;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    protected $model = Product::class;
    protected $translatePath = 'controller.product';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $products = $this->model::paginate();

        return new ResponsePaginationData([
            'paginator' => $products,
            'collection' => new ProductsCollection(['collection' => $products->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return ProductResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): ProductResponseData|NotFoundHttpException
    {
        try {
            $product = $this->model::findOrFail($id);

            return new ProductResponseData(['product' => $product, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param ProductRequest $request
     * @return ProductResponseData
     * @throws UnknownProperties
     */
    public function create(ProductRequest $request): ProductResponseData
    {
        $product = $this->model::create($request->all());

        return new ProductResponseData(['product' => $product, 'message' => __($this->translatePath . '.create')]);
    }

    /**
     * @param ProductRequest $request
     * @param int $id
     * @return ProductResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(ProductRequest $request, int $id): ProductResponseData|NotFoundHttpException
    {
        try {
            /** @var Product $product */
            $product = $this->model::findOrFail($id);
            $product->name = $request->name ?? $product->name;
            $product->slug = $request->slug ?? $product->slug;
            $product->short_description = $request->short_description ?? $product->short_description;
            $product->description = $request->description ?? $product->description;
            $product->image = $request->image ?? $product->image;
            $product->hidden = $request->hidden ?? $product->hidden;
            $product->category_id = $request->category_id ?? $product->category_id;
            $product->save();

            return new ProductResponseData(['product' => $product, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param ProductsAdditionRequest $request
     * @return JsonResponse
     */
    public function addAddition(ProductsAdditionRequest $request): JsonResponse
    {
        /** @var Product $product */
        $product = $this->model::find($request->product_id);
        /** @var Addition $addition */
        $addition = Addition::find($request->addition_id);

        $productsAddition = ProductsAddition::firstWhere(['product_id' => $request->product_id, 'addition_id' => $request->addition_id]);
        if (is_null($productsAddition)) {
            ProductsAddition::create($request->all());
            return $this->responseSuccess(__($this->translatePath . '.addAdditionSuccess', ['productName' => $product->name, 'additionName' => $addition->name]));
        } else {
            return $this->responseError(__($this->translatePath . '.addAdditionError', ['productName' => $product->name, 'additionName' => $addition->name]));
        }
    }

    /**
     * @param ProductsAdditionRequest $request
     * @return JsonResponse
     */
    public function removeAddition(ProductsAdditionRequest $request): JsonResponse
    {
        ProductsAddition::where(['product_id' => $request->product_id, 'addition_id' => $request->addition_id])->delete();
        /** @var Product $product */
        $product = $this->model::find($request->product_id);
        /** @var Addition $addition */
        $addition = Addition::find($request->addition_id);

        return $this->responseSuccess(__($this->translatePath . '.removeAddition', ['productName' => $product->name, 'additionName' => $addition->name]));
    }

    /**
     * @param ProductsPositionRequest $request
     * @return JsonResponse
     */
    public function addPosition(ProductsPositionRequest $request): JsonResponse
    {
        /** @var Product $product */
        $product = $this->model::find($request->product_id);
        /** @var Position $position */
        $position = Position::find($request->position_id);

        $productsPosition = ProductsPosition::firstWhere(['product_id' => $request->product_id, 'position_id' => $request->position_id]);
        if (is_null($productsPosition)) {
            ProductsPosition::create($request->all());
            return $this->responseSuccess(__($this->translatePath . '.addPositionSuccess', ['productName' => $product->name, 'positionName' => $position->name]));
        } else {
            return $this->responseError(__($this->translatePath . '.addPositionError', ['productName' => $product->name, 'positionName' => $position->name]));
        }
    }

    /**
     * @param ProductsPositionRequest $request
     * @return JsonResponse
     */
    public function removePosition(ProductsPositionRequest $request): JsonResponse
    {
        ProductsPosition::where(['product_id' => $request->product_id, 'position_id' => $request->position_id])->delete();
        /** @var Product $product */
        $product = $this->model::find($request->product_id);
        /** @var Position $position */
        $position = Position::find($request->position_id);

        return $this->responseSuccess(__($this->translatePath . '.removePosition', ['productName' => $product->name, 'positionName' => $position->name]));
    }

    /**
     * @param ProductsTagRequest $request
     * @return JsonResponse
     */
    public function addTag(ProductsTagRequest $request): JsonResponse
    {
        /** @var Product $product */
        $product = $this->model::find($request->product_id);
        /** @var Tag $tag */
        $tag = Tag::find($request->tag_id);

        $productsTag = ProductsTag::firstWhere(['product_id' => $request->product_id, 'tag_id' => $request->tag_id]);
        if (is_null($productsTag)) {
            ProductsTag::create($request->all());
            return $this->responseSuccess(__($this->translatePath . '.addTagSuccess', ['productName' => $product->name, 'tagName' => $tag->name]));
        } else {
            return $this->responseError(__($this->translatePath . '.addTagError', ['productName' => $product->name, 'tagName' => $tag->name]));
        }
    }

    /**
     * @param ProductsTagRequest $request
     * @return JsonResponse
     */
    public function removeTag(ProductsTagRequest $request): JsonResponse
    {
        ProductsTag::where(['product_id' => $request->product_id, 'tag_id' => $request->tag_id])->delete();
        /** @var Product $product */
        $product = $this->model::find($request->product_id);
        /** @var Tag $tag */
        $tag = Tag::find($request->tag_id);

        return $this->responseSuccess(__($this->translatePath . '.removeTag', ['productName' => $product->name, 'tagName' => $tag->name]));
    }
}
