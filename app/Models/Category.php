<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'image',
        'description',
        'state',
        'deleted',
    ];

    protected $casts = [
        'state' => 'integer',
        'deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'category_id');
    }

}
