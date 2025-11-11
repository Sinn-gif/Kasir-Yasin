<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kasir extends Authenticatable
{
    use Notifiable;

    protected $table = 'kasirs';
    protected $primaryKey = 'id_kasir';

    protected $fillable = [
        'nama_kasir',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
