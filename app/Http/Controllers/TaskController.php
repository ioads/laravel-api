<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearer",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Enter your Bearer token"
 * )
 */
class TaskController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

     /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Get a list of tasks",
     *     description="Returns a list of tasks",
     *     operationId="getTasks",
     *     tags={"Tasks"},
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of user tasks",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->taskRepository->all()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/task",
     *     summary="Create a new task",
     *     description="Creates a new task and returns it",
     *     operationId="createTask",
     *     tags={"Tasks"},
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Task object that needs to be created",
     *         @OA\JsonContent(
     *             required={"title", "description", "status"},
     *             @OA\Property(property="title", type="string", example="task title"),
     *             @OA\Property(property="content", type="string", example="task description"),
     *             @OA\Property(property="status", type="string", example="em andamento")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        return response()->json([
            'data' => json_decode($this->taskRepository->store($request->validated()), true),
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Get a single task",
     *     description="Returns a single task",
     *     operationId="getTaskById",
     *     tags={"Tasks"},
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single task",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function show(Task $task): JsonResponse
    {
        Gate::authorize('show', $task);
        
        return response()->json([
            'data' => new TaskResource($this->taskRepository->show($task))
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/task/{id}",
     *     summary="Update a task",
     *     description="Updated a task",
     *     operationId="updateTask",
     *     tags={"Tasks"},
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=false,
     *         description="Task object that needs to be updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="task title"),
     *             @OA\Property(property="content", type="string", example="task description"),
     *             @OA\Property(property="status", type="string", example="em andamento")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task updated successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        Gate::authorize('update', $task);

        return response()->json([
            'data' => $this->taskRepository->update($request->validated(), $task)
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Delete a task",
     *     description="Deletes a task",
     *     operationId="deleteTaskById",
     *     tags={"Tasks"},
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single task",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy(Task $task): JsonResponse
    {
        Gate::authorize('delete', $task);

        return response()->json([
            'data' => $this->taskRepository->destroy($task)
        ]);
    }
}
