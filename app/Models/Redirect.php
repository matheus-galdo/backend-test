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

    protected function id() : Attribute
    {
        return Attribute::make(
            get: fn (string $value) => FacadesHashids::encode($value),
        );
    }

    function getOriginalId()
    {
        return $this->id = Hashids::decode($this->id)[0] ?? null;
    }
    
    public static function findFromCode($redirectCode)
    {
        $redirectId = Hashids::decode($redirectCode)[0] ?? null;
        return self::findOrFail($redirectId);
    }

    public function redirectLogs(): HasMany
    {
        return $this->hasMany(RedirectLog::class);
    }
}
