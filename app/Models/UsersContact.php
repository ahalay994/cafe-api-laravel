<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\UsersContact
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $phone Номер телефона
 * @property string|null $first_name Имя
 * @property string|null $last_name Фамилия
 * @property string|null $patronymic_name Отчество
 * @property Carbon|null $date_birthday Дата рождения
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|UsersContact newModelQuery()
 * @method static Builder|UsersContact newQuery()
 * @method static Builder|UsersContact query()
 * @method static Builder|UsersContact whereCreatedAt($value)
 * @method static Builder|UsersContact whereDateBirthday($value)
 * @method static Builder|UsersContact whereFirstName($value)
 * @method static Builder|UsersContact whereId($value)
 * @method static Builder|UsersContact whereLastName($value)
 * @method static Builder|UsersContact wherePatronymicName($value)
 * @method static Builder|UsersContact wherePhone($value)
 * @method static Builder|UsersContact whereUpdatedAt($value)
 * @method static Builder|UsersContact whereUserId($value)
 */
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

    protected $casts = [
        'date_birthday' => 'date:d.m.Y'
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
