<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkSetup extends Model
{
    use HasFactory;

    protected $fillable = ['ca1', 'ca2', 'exam', 'total'];

    // Ensure the total is always 100
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total = $model->ca1 + $model->ca2 + $model->exam;

            // Validate that the total is 100
            if ($model->total !== 100) {
                throw new \Exception('The sum of CA1, CA2, and EXAM must be 100.');
            }
        });
    }
}
