<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // DECLARACIÓN DE CAMPOS
    protected $fillable = [
        'status',
        'lesson_id',
        'user_id'
    ];

    // MÉTODO SCOPE PARA BUSQUEDAS
    public function scopeSearch($query, $search_term)
    {
        // SI NO ES NULO ES PORQUE DESDE EL CLIENTE ENVIAN LA FECHA A CONSULTAR
        if ($search_term != null) $date = Carbon::createFromFormat('Y-m-d', $search_term)->format('Y-m-d');
        // SI ES NULO ES PORQUE SE MUESTRAN LAS CLASES PRÓXIMAS A LA FECHA ACTUAL
        else $date = now()->format('Y-m-d');
        $query->where('status', 'like', '%' . $search_term . '%')
            ->orWhereHas('lesson', function ($query_2) use ($date) {
                $query_2->orWhereHas('schedule', function ($query_3) use ($date) {
                    $query_3->whereBetween('schedules.start_hour', [$date . " 00:00:00", $date . " 23:59:59"]);
                });
            });
    }

    // RELACIÓN CON EL MODELO DE LECCIONES O CLASES 
    public function lesson()
    {
        // UNA RESERBA LE PERTENECE A UNA LECCIÓN O CLASE
        return $this->belongsTo(Lesson::class)
            ->with([
                'schedule' => function ($query) {
                    $query->select('id', 'start_hour', 'end_hour');
                }
            ]);
    }
}
