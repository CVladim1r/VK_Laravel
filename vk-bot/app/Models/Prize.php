<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'sticker_id'];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
