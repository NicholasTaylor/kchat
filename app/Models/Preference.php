<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'is_legacy',
        'top_to_bottom',
        'language',
        'country',
        'timezone',
        'clock_type',
        'email_optin',
        'menu_color'
    ];
}
