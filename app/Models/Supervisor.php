<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Supervisor extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['email', 'password', 'name', 'ppr', 'province', 'etablissement', 'encrypted_password'];

    protected $table = "supervisors";

    public function getDecryptedPasswordAttribute()
    {
        return Crypt::decryptString($this->attributes['encrypted_password']);
    }

    public function setPasswordAttribute($value)
    {

        $this->attributes['password'] = Hash::make($value);

        $this->attributes['encrypted_password'] = Crypt::encryptString($value);
    }
}