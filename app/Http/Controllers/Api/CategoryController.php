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
use Illuminate\Http\Request;
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
        $categories = Category::with(['children'])->where(['parent_id' => null])->paginate();

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
    public function show(int $id): NotFoundHttpException|CategoryResponseData
    {
        try {
            $category = Category::with(['children', 'parent'])->findOrFail($id);
            return new CategoryResponseData(['category' => $category, 'message' => 'Категория #' . $id . ' успешно получена']);
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

        return new CategoryResponseData(['category' => $category, 'message' => 'Категория успешно создана']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return CategoryResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(Request $request, int $id): NotFoundHttpException|CategoryResponseData
    {
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name ?? $category->name;
            $category->slug = $request->slug ?? $category->slug;
            $category->description = $request->description ?? $category->description;
            $category->parent_id = $request->parent_id ?? $category->parent_id;
            $category->order = $request->order ?? $category->order;
            $category->save();

            return new CategoryResponseData(['category' => $category, 'message' => 'Категория успешно обновлена']);
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
            Category::findOrFail($id)->delete();

            return $this->responseSuccess('Категория успешно удалена');
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
            Category::withTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess('Категория успешно восстановлена');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
