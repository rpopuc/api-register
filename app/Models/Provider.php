<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id', 'name', 'description', 'definition', 'owner', 'tags'];
    protected $dates = ['deleted_at'];
    protected $casts = ['id' => 'string'];
    public $incrementing = false;

    public function consumers()
    {
        return $this->hasMany(Consumer::class);
    }
}
