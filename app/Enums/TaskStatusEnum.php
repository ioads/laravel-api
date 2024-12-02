<?php

namespace App\Enums;
 
enum TaskStatusEnum:string {
    case Pending = 'pendente';
    case InProgress = 'em andamento';
    case Completed = 'concluída';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}