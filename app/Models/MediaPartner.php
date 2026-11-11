<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'website_url',
        'institution',
        'contact_email',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_media_partner')->withTimestamps();
    }

    public function legacyEvents(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
