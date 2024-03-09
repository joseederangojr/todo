<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Space;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class SpaceTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Space $space)
    {
        Gate::authorize('viewAny', [Task::class, $space]);

        return response()->json([
            'data' => $space->tasks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Space $space)
    {
        $task = $space->tasks()->create($request->validated());

        return response()->json(
            [
                'data' => $task,
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Space $space, Task $task)
    {
        Gate::authorize('view', [$task, $space]);

        return response()->json([
            'data' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Space $space, Task $task)
    {
        $task->update($request->validated());

        return back(status: 303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Space $space, Task $task)
    {
        Gate::authorize('delete', [$task, $space]);

        $task->delete();

        return response()->noContent();
    }
}
