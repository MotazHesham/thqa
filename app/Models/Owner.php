<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'owners';

    public static $searchable = [
        'identity_num',
    ];

    public const GENDER_SELECT = [
        'male'   => 'ذكر',
        'female' => 'أنثي',
    ];

    protected $dates = [
        'identity_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'gender',
        'identity_num',
        'identity_date',
        'address',
        'commerical_num',
        'real_estate_identity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function ownerBuildings()
    {
        return $this->hasMany(Building::class, 'owner_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getIdentityDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setIdentityDateAttribute($value)
    {
        $this->attributes['identity_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
