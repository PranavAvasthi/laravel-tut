<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'completed'])]
class Task extends Model
{
    protected function casts(): array
    {
        return [
            'completed' => 'boolean' 
        ];
    }
}
