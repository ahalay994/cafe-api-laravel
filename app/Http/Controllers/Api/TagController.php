<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ResponsePaginationData;
use App\DataTransferObjects\Tag\TagResponseData;
use App\DataTransferObjects\Tag\TagsCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{
    protected $model = Tag::class;
    protected $translatePath = 'controller.tag';

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
            $tag = $this->model::findOrFail($id);

            return new TagResponseData(['tag' => $tag, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $tag = $this->model::create($request->all());

        return new TagResponseData(['tag' => $tag, 'message' => __($this->translatePath . '.create')]);
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
            /** @var Tag $tag */
            $tag = $this->model::findOrFail($id);
            $tag->name = $request->name ?? $tag->name;
            $tag->slug = $request->slug ?? $tag->slug;
            $tag->save();

            return new TagResponseData(['tag' => $tag, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
