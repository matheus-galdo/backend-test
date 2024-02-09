<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids as FacadesHashids;

class Redirect extends Model
{
    use HasFactory;

    protected function id() : Attribute {
        //TODO: refatorar pra eliminar dependência
        return Attribute::make(
            get: fn (string $value) => FacadesHashids::encode($value),
        );
    }
    
    protected $fillable = ['code', 'url', 'status'];
}
