<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Lesson;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReservations(Request $request)
    {
        $reservations = Reservation::search($request->search, $request->date) // SCOPE DE BUSQUEDA
            ->join('lessons', 'lessons.id', '=', 'reservations.lesson_id') // RELACIÓN CON LA LECCIÓN O CLASE
            ->orderBy('reservations.created_at', 'DESC') // ORDENAMIENTO SEGÚN CREACIÓN
            ->simplePaginate(10); // PAGINADO
        return response()->json(['reservations' => $reservations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        try {
            $request->validated(); // VALIDACIÓN DE CAMPOS
            if ($request->lesson_id != null) // VALIDACIÓN DE QUE NO VAYA NULO LA LECCIÓN O CLASE
                $lesson = Lesson::where('lessons.id', $request->lesson_id)
                    ->join('schedules', 'schedules.id', '=', 'lessons.schedule_id')
                    ->first(); // CONSULTA PARA VALIDAR QUE EL PARAMETRO QUE ENVÍAN EXISTA Y QUE ESTE DENTRO DEL RANGO DE LOS 8 DÍAS  
            else return response()->json(['msg' => 'La clase no existe o no está disponible en el momento', 'icon' => 'error'], 500);
            if ($request->user_id != null) // VALIDACIÓN DE QUE NO VAYA NULO EL USUARIO
                $user = User::where('id', $request->user_id)->first();
            else return response()->json(['msg' => 'El usuario no existe', 'icon' => 'error'], 500);
            if ($lesson && $user) {
                $reservation  = new Reservation($request->all());
                $reservation->save();
                // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
                return response()->json(['msg' => 'La reservación se registró con éxito.', 'icon' => 'success', 'reservation' => $reservation]);
            } else return response()->json(['msg' => 'No se cumplen los parametros requeridos', 'icon' => 'error'], 500);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $reservation->lesson; // RELACIÓN CON LA LECCIÓN 
        return response()->json(['reservation' => $reservation]); // ENVÍO AL CLIENTE DEL DETALLE DE LA RESERVACIÓN
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationRequest $request, Reservation $reservation)
    {
        try {
            $request->validated(); // VALIDACIÓN DE CAMPOS
            if ($request->lesson_id != null) // VALIDACIÓN DE QUE NO VAYA NULO LA LECCIÓN O CLASE
                $lesson = Lesson::where('lessons.id', $request->lesson_id)
                    ->join('schedules', 'schedules.id', '=', 'lessons.schedule_id')
                    ->first(); // CONSULTA PARA VALIDAR QUE EL PARAMETRO QUE ENVÍAN EXISTA Y QUE ESTE DENTRO DEL RANGO DE LOS 8 DÍAS  
            else return response()->json(['msg' => 'La clase no existe o no está disponible en el momento', 'icon' => 'error'], 500);
            if ($request->user_id != null) // VALIDACIÓN DE QUE NO VAYA NULO EL USUARIO
                $user = User::where('id', $request->user_id)->first();
            else return response()->json(['msg' => 'El usuario no existe', 'icon' => 'error'], 500);

            if ($lesson && $user) {
                $reservation->update($request->all());
                // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
                return response()->json(['msg' => 'La reservación se actualizó con éxito.', 'icon' => 'success', 'reservation' => $reservation]);
            } else return response()->json(['msg' => 'No se cumplen los parametros requeridos', 'icon' => 'error'], 500);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete(); // ELIMINACIÓN DE LA RESERVA
            return response()->json(['msg' => 'Se eliminó con éxito', 'icon' => 'success']); // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }
}
