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
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $products = Product::with(['category', 'additions', 'positions'])->paginate();

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
    public function show(int $id): NotFoundHttpException|ProductResponseData
    {
        try {
            $product = Product::with(['positions'])->findOrFail($id);
            return new ProductResponseData(['product' => $product, 'message' => 'Продукция #' . $id . ' успешно получена']);
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
        $product = Product::create($request->all());

        return new ProductResponseData(['product' => $product, 'message' => 'Продукция успешно создана']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return ProductResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(Request $request, int $id): NotFoundHttpException|ProductResponseData
    {
        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name ?? $product->name;
            $product->slug = $request->slug ?? $product->slug;
            $product->save();

            return new ProductResponseData(['product' => $product, 'message' => 'Продукция успешно обновлена']);
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
            Product::findOrFail($id)->delete();

            return $this->responseSuccess('Продукция успешно удалена');
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
            Product::withTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess('Продукция успешно восстановлена');
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
        $product = Product::find($request->product_id);
        $addition = Addition::find($request->addition_id);

        $productsAddition = ProductsAddition::where(['product_id' => $request->product_id, 'addition_id' => $request->addition_id])->first();
        if (is_null($productsAddition)) {
            ProductsAddition::create($request->all());
            return $this->responseSuccess('Продукции "' . $product->name . '" присвоено дополнение "' . $addition->name . '"');
        } else {
            return $this->responseError('Продукции "' . $product->name . '" уже присвоено дополнение "' . $addition->name . '"');
        }
    }

    /**
     * @param ProductsAdditionRequest $request
     * @return JsonResponse
     */
    public function removeAddition(ProductsAdditionRequest $request): JsonResponse
    {
        ProductsAddition::where(['product_id' => $request->product_id, 'addition_id' => $request->addition_id])->delete();
        $product = Product::find($request->product_id);
        $addition = Addition::find($request->addition_id);

        return $this->responseSuccess('У продукции "' . $product->name . '" удалено дополнение "' . $addition->name . '"');
    }

    /**
     * @param ProductsPositionRequest $request
     * @return JsonResponse
     */
    public function addPosition(ProductsPositionRequest $request): JsonResponse
    {
        $product = Product::find($request->product_id);
        $position = Position::find($request->position_id);

        $productsPosition = ProductsPosition::where(['product_id' => $request->product_id, 'position_id' => $request->position_id])->first();
        if (is_null($productsPosition)) {
            ProductsPosition::create($request->all());
            return $this->responseSuccess('Продукции "' . $product->name . '" присвоена позиция "' . $position->name . '"');
        } else {
            return $this->responseError('Продукции "' . $product->name . '" уже присвоена позиция "' . $position->name . '"');
        }
    }

    /**
     * @param ProductsPositionRequest $request
     * @return JsonResponse
     */
    public function removePosition(ProductsPositionRequest $request): JsonResponse
    {
        ProductsPosition::where(['product_id' => $request->product_id, 'position_id' => $request->position_id])->delete();
        $product = Product::find($request->product_id);
        $position = Position::find($request->position_id);

        return $this->responseSuccess('У продукции "' . $product->name . '" удалена позиция "' . $position->name . '"');
    }

    /**
     * @param ProductsTagRequest $request
     * @return JsonResponse
     */
    public function addTag(ProductsTagRequest $request): JsonResponse
    {
        $product = Product::find($request->product_id);
        $tag = Tag::find($request->tag_id);

        $productsTag = ProductsTag::where(['product_id' => $request->product_id, 'tag_id' => $request->tag_id])->first();
        if (is_null($productsTag)) {
            ProductsTag::create($request->all());
            return $this->responseSuccess('Продукции "' . $product->name . '" присвоена метка "' . $tag->name . '"');
        } else {
            return $this->responseError('Продукции "' . $product->name . '" уже присвоена метка "' . $tag->name . '"');
        }
    }

    /**
     * @param ProductsTagRequest $request
     * @return JsonResponse
     */
    public function removeTag(ProductsTagRequest $request): JsonResponse
    {
        ProductsTag::where(['product_id' => $request->product_id, 'tag_id' => $request->tag_id])->delete();
        $product = Product::find($request->product_id);
        $tag = Tag::find($request->tag_id);

        return $this->responseSuccess('У продукции "' . $product->name . '" удалена метка "' . $tag->name . '"');
    }
}
