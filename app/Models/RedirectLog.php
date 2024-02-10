<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vinkla\Hashids\Facades\Hashids;

class RedirectLog extends Model
{
    use HasFactory;

    protected $fillable = ['redirect_id', 'ip_address', 'referer', 'query_params', 'user_agent'];
    protected $hidden = ['redirect_id'];

    public function redirect(): BelongsTo
    {
        return $this->belongsTo(Redirect::class);
    }

    protected static function booted()
    {
        static::retrieved(function ($model) {
            $model->code = Hashids::encode($model->redirect_id);
        });
    }
}
