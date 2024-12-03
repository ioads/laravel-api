<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => $this->taskRepository->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        return response()->json([
            'data' => $this->taskRepository->store($request->validated()),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('show', $task);
        
        return response()->json([
            'data' => $this->taskRepository->show($task)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        return response()->json([
            'data' => $this->taskRepository->update($request->validated(), $task)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        return response()->json([
            'data' => $this->taskRepository->destroy($task)
        ]);
    }
}
