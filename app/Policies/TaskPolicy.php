<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TaskPolicy
{
    public function show(User $user, Task $task)
    {
        $can = $user->id === $task->user_id;
        if(!$can) {
            Log::info('User {userId} unauthorized to show task {taskId}.', ['userId' => $user->id, 'taskId' => $task->id]);
        }
        return $can;
    }

    public function update(User $user, Task $task): bool
    {
        $can = $user->id === $task->user_id;
        if(!$can) {
            Log::info('User {userId} unauthorized to update task {taskId}.', ['userId' => $user->id, 'taskId' => $task->id]);
        }
        return $can;
    }
    
    public function delete(User $user, Task $task): bool
    {
        $can = $user->id === $task->user_id;
        if(!$can) {
            Log::info('User {userId} unauthorized to delete task {taskId}.', ['userId' => $user->id, 'taskId' => $task->id]);
        }
        return $can;
    }
}
