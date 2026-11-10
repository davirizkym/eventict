<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'category',
        'type',
        'format',
        'location',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'quota',
        'price',
        'skp_points',
        'sk_number',
        'description',
        'status',
        'organizer_type',
        'media_partner_id',
        'organizer_name',
        'registration_url',
        'banner_url',
        'virtual_meeting_url',
        'is_presence_open',
        'presence_token',
    ];

    public function isExternal(): bool
    {
        return ($this->organizer_type === 'partner') || !empty($this->registration_url);
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'quota' => 'integer',
            'price' => 'integer',
            'skp_points' => 'integer',
            'is_presence_open' => 'boolean',
        ];
    }

    public function categoryRel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function mediaPartner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MediaPartner::class, 'media_partner_id');
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'event_speaker')
            ->withPivot(['topic', 'session_time', 'role'])
            ->withTimestamps();
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
