<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsersContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'patronymic_name',
        'phone',
        'date_birthday',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->patronymic_name;
    }

    /**
     * @return string
     */
    public function getDateBirthday(): string {
        return $this->date_birthday->format('d.m.Y');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
