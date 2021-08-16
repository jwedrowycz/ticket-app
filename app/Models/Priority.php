<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getStateAttribute($value)
    {
        switch($value){
            case 0: 
                return 'Niski';
            case 1:
                return 'Średni';
            case 2: 
                return 'Wysoki';
        }
    }
}
