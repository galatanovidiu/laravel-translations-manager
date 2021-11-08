<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    public function translation()
    {
        return $this->hasOne(Translation::class)->withDefault(['translation' => '']);
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

}
