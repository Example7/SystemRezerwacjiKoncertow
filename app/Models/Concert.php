<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Concert extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'tags',
        'location_id',
        'concert_date',
        'ticket_limit',
        'email',
        'price',
        'website',
        'user_id',
    ];

    protected $casts = [
        'concert_date' => 'datetime',
    ];

    protected $appends = ['tags_array'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getTagsArrayAttribute()
    {
        return explode(',', $this->tags);
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['tag'])) {
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('tags', 'like', '%' . $search . '%')
                    ->orWhereHas('location', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%')
                            ->orWhere('address', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('artists', function ($q3) use ($search) {
                        $q3->where('name', 'like', '%' . $search . '%');
                    });
            });
        }
    }

    public function getAvailableTicketsAttribute()
    {
        return $this->tickets()->whereNull('reservation_id')->count();
    }

    public function getTicketPriceAttribute()
    {
        $firstTicket = $this->tickets()->first();
        return $firstTicket ? $firstTicket->price : 0;
    }

    public function getRatingsAvgAttribute()
    {
        return $this->ratings()->avg('value') ?? 0;
    }

    public function getRatingsCountAttribute()
    {
        return $this->ratings()->count();
    }
}
