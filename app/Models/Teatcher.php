<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teatcher extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['email', 'password', 'name', 'ppr', 'subject_id', 'province', 'etablissement', 'encrypted_password'];

    protected $table = "teachers";


    public function setPasswordAttribute($value)
    {
        // Store the hashed password for authentication
        $this->attributes['password'] = Hash::make($value);

        // Store the encrypted password for later retrieval (if needed)
        $this->attributes['encrypted_password'] = Crypt::encryptString($value);
    }



    public function getDecryptedPasswordAttribute()
    {
        return Crypt::decryptString($this->attributes['encrypted_password']);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function attachClass($className)
    {
        $exists = DB::table('teacher_class')
            ->where('teacher_id', $this->id)
            ->where('class_name', $className)
            ->exists();

        if (!$exists) {
            DB::table('teacher_class')->insert([
                'teacher_id' => $this->id,
                'class_name' => $className,
            ]);
        }
    }

    public function getClasses()
    {
        $classNames = DB::table('teacher_class')
            ->where('teacher_id', $this->id)
            ->pluck('class_name');


        $classNamesString = $classNames->implode(', ');
        return $classNamesString;
    }
    public function updateClasses(array $newClassNames)
    {

        $currentClassNames = DB::table('teacher_class')
            ->where('teacher_id', $this->id)
            ->pluck('class_name')
            ->toArray();
        $classesToRemove = array_diff($currentClassNames, $newClassNames);
        $classesToAdd = array_diff($newClassNames, $currentClassNames);
        DB::table('teacher_class')
            ->where('teacher_id', $this->id)
            ->whereIn('class_name', $classesToRemove)
            ->delete();
        foreach ($classesToAdd as $className) {
            $this->attachClass($className);
        }
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($teacher) {
            DB::table('teacher_class')->where('teacher_id', $teacher->id)->delete();
        });
    }
}