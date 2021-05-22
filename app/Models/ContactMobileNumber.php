<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ContactMobileNumber extends Model
{
    protected $fillable = ['contact_id', 'number', 'note'];
}