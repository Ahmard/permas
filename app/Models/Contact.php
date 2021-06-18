<?php


namespace App\Models;


use App\Auth;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id', 'mobile_number_id', 'address_id', 'email_address_id',
        'name', 'photo', 'gender'
    ];


    public static function create(int $userId, array $userData): Model|Contact
    {
        $userData['user_id'] = Auth::userId();
        $contact = self::query()->create($userData);

        ContactAddress::query()->create([
            ''
        ]);

        return $contact;
    }
}