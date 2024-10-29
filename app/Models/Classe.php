<?php

namespace App\Models;

use App\Models\Teatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number', 'supervisor_id'];

    protected $table = 'classes';

    public function attachClass($className)
    {

        $exists = DB::table('class_teacher')
            ->where('teacher_id', $this->id)
            ->where('class_name', $className)
            ->exists();

        if (!$exists) {
            DB::table('class_teacher')->insert([
                'teacher_id' => $this->id,
                'class_name' => $className,
            ]);
        }
    }
}
