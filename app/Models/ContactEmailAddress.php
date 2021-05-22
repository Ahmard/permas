<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ContactEmailAddress extends Model
{
    protected $fillable = ['contact_id', 'email', 'note'];
}