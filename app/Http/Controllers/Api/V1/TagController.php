<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTagRequest;
use App\Http\Requests\Api\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\TaskResource;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TagController extends Controller
{

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $tags = Tag::query()
            ->with(['tasks'])
            ->paginate(9);

        return TagResource::collection($tags);
    }


    /**
     * @param StoreTagRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::query()
            ->create($request->validated());

        return response([
            'tag' => new TagResource($tag),
            'msg' => __('messages.add_tag')
        ]);
    }


    /**
     * @param Tag $tag
     * @return Application|ResponseFactory|Response
     */
    public function show(Tag $tag)
    {
        return response([
            'tag' => new TagResource($tag),
            'tag_tasks' => TaskResource::collection($tag->tasks),
        ]);
    }


    /**
     * @param UpdateTagRequest $request
     * @param Tag $tag
     * @return Application|ResponseFactory|Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return response([
            'tag' => new TagResource($tag),
            'msg' => __('messages.update_tag')
        ]);
    }


    /**
     * @param Tag $tag
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response([
            'msg' => __('messages.delete_tag')
        ]);
    }
}
