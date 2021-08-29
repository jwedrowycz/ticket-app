<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'descr', 'user_id', 'status_id', 'priority_id', 'category_id'];
    
    protected function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeWithFilters()
    {
        return $this->when(request()->query('tickets'), function($query) {
            $query->where('status_id', request()->query('tickets'));
        });
    }
}
