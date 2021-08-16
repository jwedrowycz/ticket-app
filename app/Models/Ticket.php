<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'descr', 'user_id', 'status_id', 'priority_id'];
    
    protected function status()
    {
        return $this->belongsTo(Status::class);
    }

    protected function priority()
    {
        return $this->belongsTo(Priority::class);
    }
}
