<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NoteCategory extends Model
{
    protected $fillable = ['user_id', 'name'];
}