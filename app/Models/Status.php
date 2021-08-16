<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function getStateAttribute($value)
    {
        switch($value){
            case 0: 
                return 'Wysłane';
            case 1:
                return 'W realizacji';
            case 2: 
                return 'Zrealizowane';
        }
    }
}
