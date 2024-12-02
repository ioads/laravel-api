<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    protected $model;

    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function all()
    {
        return auth()->user()->tasks;
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function store(array $data)
    {
        return auth()->user()->tasks()->create($data);
    }

    public function update(array $data, Task $task)
    {
        return $task->update($data);
    }

    public function destroy(Task $task)
    {
        return $task->delete();
    }
}