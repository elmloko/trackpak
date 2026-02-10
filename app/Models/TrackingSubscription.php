<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingSubscription extends Model
{
    use HasFactory;

     protected $fillable = ['codigo', 'fcm_token', 'last_sig'];
}
