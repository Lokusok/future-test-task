<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'create_date',
        'status',
        'priority',
        'category',
    ];

    public $timestamps = false;

    public function scopeOfSearch(Builder $query, ?string $search): void
    {
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }
    }

    public function scopeOfSort(Builder $query, ?string $sortField): void
    {
        if ($sortField) {
            $query->orderBy($sortField);
        }
    }
}
