<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Define the relationship with notes
    public function notes() {
        return $this->hasMany(Note::class);
    }
}
