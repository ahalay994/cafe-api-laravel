<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Category\CategoriesCollection;
use App\DataTransferObjects\Category\CategoryResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    protected $model = Category::class;
    protected $translatePath = 'controller.category';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $categories = $this->model::where(['parent_id' => null])->paginate();

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
            $category = $this->model::findOrFail($id);

            return new CategoryResponseData(['category' => $category, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $category = $this->model::create($request->all());
        $category = $this->model::find($category->id);

        return new CategoryResponseData(['category' => $category, 'message' => __($this->translatePath . '.create')]);
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
            /** @var Category $category */
            $category = $this->model::findOrFail($id);
            $category->name = $request->name ?? $category->name;
            $category->slug = $request->slug ?? $category->slug;
            $category->description = $request->description ?? $category->description;
            $category->parent_id = $request->parent_id ?? $category->parent_id;
            $category->order = $request->order ?? $category->order;
            $category->save();

            return new CategoryResponseData(['category' => $category, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
