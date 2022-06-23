<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    // DECLARACIÓN DE CAMPOS
    protected $fillable = [
        'coach',
        'location',
        'limit',
        'type',
        'schedule_id'
    ];

    // MÉTODO SCOPE PARA BUSQUEDAS
    public function scopeSearch($query, $search_term)
    {
        $query->where('coach', 'like', '%' . $search_term . '%')
            ->orWhere('location', 'like', '%' . $search_term . '%')
            ->orWhere('type', 'like', '%' . $search_term . '%');
    }

    /* CONSULTA PARA LISTAR LAS CLASES QUE INICIAN 8 DÍAS DESPÚES 
       DE LA FECHA ACTUAL O LA QUE ENVIEEN POR PARAMETRO */
    public function scopeSearchSchedule($query, $date_term)
    {
        // SI NO ES NULO ES PORQUE DESDE EL CLIENTE ENVIAN LA FECHA A CONSULTAR
        if ($date_term != null) $date = Carbon::createFromFormat('Y-m-d', $date_term)->addDays(8)->format('Y-m-d');
        // SI ES NULO ES PORQUE SE MUESTRAN LAS CLASES PRÓXIMAS A LA FECHA ACTUAL
        else $date = now()->addDays(8)->format('Y-m-d');
        $query->select(
            'lessons.id AS l_id',
            'lessons.coach AS l_coach',
            'lessons.location AS l_location',
            'lessons.limit AS l_limit',
            'lessons.type AS l_type',
            'lessons.schedule_id AS l_schedule_id',
            'schedules.id AS s_id',
            'schedules.start_hour AS s_start_hour',
            'schedules.end_hour AS s_end_hour'
        )->whereBetween('schedules.start_hour', [$date . " 00:00:00", $date . " 23:59:59"]);

    }

    // RELACIÓN CON EL MODELO DE HORARIOS
    public function schedule()
    {
        // UNA CLASE LE PERTENECE A UN HORARIO
        return $this->belongsTo(Schedule::class);
    }

    // RELACIÓN CON EL MODELO DE RESERVAS
    public function reservations()
    {
        // UNA LECCIÓN O CLASE TIENE UNA O MUCHAS RESERVAS
        return $this->hasMany(Reservation::class);
    }
}
