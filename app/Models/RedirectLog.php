<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedirectLog extends Model
{
    use HasFactory;
    
    protected $fillable = ['redirect_id', 'ip_address', 'referer', 'query_params'];
    
    public function redirect(): BelongsTo
    {
        return $this->belongsTo(Redirect::class);
    }
}
