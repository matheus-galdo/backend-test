<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids as FacadesHashids;

class Redirect extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected function id() : Attribute {
        return Attribute::make(
            get: fn (string $value) => FacadesHashids::encode($value),
        );
    }
    
    protected $fillable = ['code', 'url', 'status'];
}
