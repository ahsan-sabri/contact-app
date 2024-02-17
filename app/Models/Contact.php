<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class Contact extends Model
{
    use HasFactory;

    public mixed $id;
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
}
