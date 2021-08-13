<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'descr'];
    
    protected function status()
    {
        return $this->belongsTo(Status::class);
    }

    protected function priority()
    {
        return $this->belongsTo(Priority::class);
    }
}
