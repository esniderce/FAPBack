<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    protected $table = 'doctors';

    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'imagen',
        'category_id',
        'hospital_id',
        'phone_number',
        'favorite',
        'email',
        'about_me',
        'experience',
        'hospital_experience',
        'deleted',
    ];

    protected $casts = [
        'experience' => 'array',
        'favorite' => 'boolean',
        'deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
}
