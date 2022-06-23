<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSchedules(Request $request): \Illuminate\Http\JsonResponse
    {
        $schedules = Schedule::search($request->search)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(10);
        return response()->json(['schedules' => $schedules]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        try {
            $request->validated();
            $schedule  = new Schedule($request->all());
            $schedule->save();
            // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
            return response()->json(['msg' => 'El horario se registró con éxito.', 'icon' => 'success', 'schedule' => $schedule]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return response()->json(['schedule' => $schedule]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        try {
            $request->validated();
            $schedule->update($request->all()); // ACTUALIZACIÓN
            // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
            return response()->json(['msg' => 'El horario se actualizó con éxito.', 'icon' => 'success', 'schedule' => $schedule]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        try {
            if (count($schedule->lesson) == 0) { // SI NO ESTÁ RELACIONADO A UNA CLASE
                $schedule->delete();
                // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
                return response()->json([
                    'msg' => 'Se eliminó con éxito',
                    'icon' => 'success'
                ]);
            } else
                // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
                return response()->json([
                    'msg' => 'NO se puede eliminar este horario ya que está relacionado a una clase',
                    'icon' => 'error'
                ], 500);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }
}
