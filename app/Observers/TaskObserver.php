<?php

namespace App\Observers;

use App\Events\TaskNotification;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $this->clearUserCache($task->user_id);
        $this->sendNotification('Nova tarefa criada!');
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $this->clearUserCache($task->user_id);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $this->clearUserCache($task->user_id);
    }

    public function clearUserCache($userId)
    {
        return Redis::del('task:user:' . $userId);
    }

    public function sendNotification($message)
    {
        Log::info('Notificação enviada: {message}', ['message' => $message]);
        broadcast(new TaskNotification($message));
    }
}
