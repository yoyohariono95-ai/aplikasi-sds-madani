<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function topics()
    {
        return $this->hasMany(Topic::class, 'subject_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'subject_id');
    }
}
