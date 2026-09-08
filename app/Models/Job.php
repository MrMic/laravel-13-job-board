<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory;

    public static array $experience = ['entry', 'intermediate', 'senior'];

    public static array $category = ['IT', 'Finance', 'Sales',  'Marketing'];

    /* protected $fillable = [ */
    /*     'title', */
    /*     'description', */
    /*     'salary', */
    /*     'location', */
    /*     'category', */
    /*     'experience', */
    /* ]; */
}
