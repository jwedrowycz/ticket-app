<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'descr', 'user_id', 'status_id', 'priority_id', 'category_id', 'updated_by', 'screenshot'];
    
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

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function scopeWithFilters($query)
    {
        return $query->when(request()->query('status') != 0, function($q) {
            $q->where('status_id', request()->query('status'));
        })
        ->when(request()->query('priority') != 0, function($q) {
            $q->where('priority_id', request()->query('priority'));
        });
    }


    public function scopeWithCategory($query, $category)
    {
        return $query->when(!is_null($category), function($q) use ($category) {
            $q->where('category_id', $category->id);
        });
    }
}
