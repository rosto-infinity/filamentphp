<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    protected $fillable = ["name", "country_id"];

    
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    
    public function cities ():HasMany
   {
    return $this->hasMany(City::class);
   }
    public function users ():HasMany
   {
    return $this->hasMany(User::class);
   }
}
