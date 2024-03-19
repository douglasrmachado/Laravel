<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turma extends Model
{
    use SoftDeletes;

    use HasFactory;

    public function curso() {
       return $this->belongsTo('\App\Models\Curso');
    }
}
