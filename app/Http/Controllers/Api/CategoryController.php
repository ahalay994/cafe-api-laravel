<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Category\CategoriesCollection;
use App\DataTransferObjects\Category\CategoryResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $categories = Category::where(['parent_id' => null])->paginate();

        return new ResponsePaginationData([
            'paginator' => $categories,
            'collection' => new CategoriesCollection(['collection' => $categories->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return CategoryResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): CategoryResponseData|NotFoundHttpException
    {
        try {
            $category = Category::findOrFail($id);

            return new CategoryResponseData(['category' => $category, 'message' => __('controller.category.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param CategoryRequest $request
     * @return CategoryResponseData
     * @throws UnknownProperties
     */
    public function create(CategoryRequest $request): CategoryResponseData
    {
        $category = Category::create($request->all());
        $category = Category::find($category->id);

        return new CategoryResponseData(['category' => $category, 'message' => __('controller.category.create')]);
    }

    /**
     * @param CategoryRequest $request
     * @param int $id
     * @return CategoryResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(CategoryRequest $request, int $id): CategoryResponseData|NotFoundHttpException
    {
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name ?? $category->name;
            $category->slug = $request->slug ?? $category->slug;
            $category->description = $request->description ?? $category->description;
            $category->parent_id = $request->parent_id ?? $category->parent_id;
            $category->order = $request->order ?? $category->order;
            $category->save();

            return new CategoryResponseData(['category' => $category, 'message' => __('controller.category.update', ['id' => $id])]);
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
            Category::destroy($id);

            return $this->responseSuccess(__('controller.category.delete', ['id' => $id]));
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
            Category::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.category.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
