<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ResponsePaginationData;
use App\DataTransferObjects\Tag\TagResponseData;
use App\DataTransferObjects\Tag\TagsCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $tags = Tag::paginate();

        return new ResponsePaginationData([
            'paginator' => $tags,
            'collection' => new TagsCollection(['collection' => $tags->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return TagResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): TagResponseData|NotFoundHttpException
    {
        try {
            $tag = Tag::findOrFail($id);

            return new TagResponseData(['tag' => $tag, 'message' => __('controller.tag.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param TagRequest $request
     * @return TagResponseData
     * @throws UnknownProperties
     */
    public function create(TagRequest $request): TagResponseData
    {
        $tag = Tag::create($request->all());

        return new TagResponseData(['tag' => $tag, 'message' => __('controller.tag.create')]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return TagResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(Request $request, int $id): TagResponseData|NotFoundHttpException
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->name = $request->name ?? $tag->name;
            $tag->slug = $request->slug ?? $tag->slug;
            $tag->save();

            return new TagResponseData(['tag' => $tag, 'message' => __('controller.tag.update', ['id' => $id])]);
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
            Tag::destroy($id);

            return $this->responseSuccess(__('controller.tag.delete', ['id' => $id]));
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
            Tag::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.tag.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
