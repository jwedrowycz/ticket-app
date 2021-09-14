<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getValueAttribute($value)
    {
        switch($value){
            case 0: 
                return 'Awarie';
            case 1:
                return 'Zapotrzebowanie';
            case 2: 
                return 'Pytania';
        }
    }   
}
