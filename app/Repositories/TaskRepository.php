<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class TaskRepository implements TaskRepositoryInterface
{
    protected $model;

    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function all()
    {
        $user = auth()->user();
        $key = 'task:user:'.$user->id;
        
        $cache = Redis::get($key);
        if($cache) {
            return json_decode($cache, true);
        }

        $tasks = $user->tasks;
        Redis::set($key, $tasks);
        return $tasks;
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