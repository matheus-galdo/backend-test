<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use \Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids as FacadesHashids;

class Redirect extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['url', 'status'];

    protected $hidden = ['id'];

    function getId()
    {
        return $this->id;
    }

    public function redirectLogs(): HasMany
    {
        return $this->hasMany(RedirectLog::class);
    }

    protected static function booted()
    {
        static::retrieved(function ($model) {
            $model->code = FacadesHashids::encode($model->id);
        });
    }
}
