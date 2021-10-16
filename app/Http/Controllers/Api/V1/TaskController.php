<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Http\Requests\Api\UpdateTaskRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $tasks = Task::query()
            ->with(['tags', 'user'])
            ->filter($request->user_id)
            ->paginate(9);

        return TaskResource::collection($tasks);
    }


    /**
     * @param StoreTaskRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(StoreTaskRequest $request)
    {

        $task = Task::query()
            ->create($request->validated());

        $task->tags()->sync($request->tags);

        return response([
            'task' => new TaskResource($task),
            'task_tags' => TagResource::collection($task->tags),
            'msg' => __('messages.add_task')
        ]);
    }


    /**
     * @param Task $task
     * @return Application|ResponseFactory|Response
     */
    public function show(Task $task)
    {
        return response([
            'task' => new TaskResource($task),
            'task_tags' => TagResource::collection($task->tags),
        ]);

    }


    /**
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return Application|ResponseFactory|Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        $task->tags()->sync($request->tags);
        return response([
            'task' => new TaskResource($task),
            'task_tags' => TagResource::collection($task->tags),
            'msg' => __('messages.update_task')
        ]);
    }


    /**
     * @param Task $task
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response([
            'msg' => __('messages.delete_task')
        ]);
    }
}
