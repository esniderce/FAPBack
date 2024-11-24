<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use SoftDeletes;

    protected $table = 'hospitals';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email',
        'deleted',
    ];

    protected $casts = [
        'deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
