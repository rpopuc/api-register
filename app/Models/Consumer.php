<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consumer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id', 'provider_id', 'name', 'description', 'definition', 'owner', 'tags'];
    protected $dates = ['deleted_at'];
    protected $casts = ['id' => 'string'];
    public $incrementing = false;

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function belongTo(Provider $provider): bool
    {
        return $provider->id == $this->provider->id;
    }
}
