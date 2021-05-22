<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ContactAddress extends Model
{
    protected $fillable = ['contact_id', 'address', 'country', 'state', 'city', 'note'];
}