<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'contactNumber',
        'address',
        'partner',
        'totalPartner',
        'attending',
        'alreadyAttend',
        'message',
        'wishes',
        'typeForm',
        'urlFrom',
        'updated_at'
    ];
}
