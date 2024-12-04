<?php

namespace App\Interfaces;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function all();
    public function show(Task $task);
    public function store(array $data);
    public function update(array $data, Task $task);
    public function destroy(Task $task);
}