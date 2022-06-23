<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // DECLARACIÓN DE CAMPOS
    protected $fillable = [
        'start_hour',
        'end_hour',
    ];

    // MÉTODO SCOPE PARA BUSQUEDAS
    public function scopeSearch($query, $search_term)
    {
        $query->where('start_hour', 'like', '%' . $search_term . '%')
            ->orWhere('end_hour', 'like', '%' . $search_term . '%');
    }

    // RELACIÓN CON EL MODELO DE CLASE O LECCIONES
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
