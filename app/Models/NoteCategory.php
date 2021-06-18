<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NoteCategory extends Model
{
    protected $fillable = ['parent_id', 'user_id', 'name'];
}