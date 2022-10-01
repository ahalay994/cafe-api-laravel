<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Partner
 *
 * @property int $id
 * @property string $name
 * @property string $image
 */
class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
