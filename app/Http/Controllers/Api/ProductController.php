<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Product\ProductResponseData;
use App\DataTransferObjects\Product\ProductsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
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
        $products = Product::with(['category'])->paginate();

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
            $product = Product::with(['category'])->findOrFail($id);
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
}
