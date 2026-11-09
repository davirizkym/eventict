<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'institution',
        'contact_email',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
