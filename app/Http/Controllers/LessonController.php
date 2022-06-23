<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLessons(Request $request): \Illuminate\Http\JsonResponse
    {
        $lessons = Lesson::search($request->search) // SCOPE PARA BUSQUEDA
            ->SearchSchedule($request->date) // MÉTODO PARA CONSULTAR POR HORARIOS
            ->join('schedules', 'schedules.id', '=', 'lessons.schedule_id') // RELACIÓN CON LOS HORARIOS
            ->orderBy('lessons.created_at', 'DESC') // ORDENAMIENTO SEGPUN CREACIÓN
            ->simplePaginate(10); // PAGINADO
        return response()->json(['lessons' => $lessons]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        try {
            $request->validated(); // VALIDACIÓN
            $lesson  = new Lesson($request->all());
            $lesson->save(); // ALMACENAMIENTO
            // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
            return response()->json(['msg' => 'La clase se registró con éxito.', 'icon' => 'success', 'lesson' => $lesson]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        return response()->json(['lesson' => $lesson]);  // ENVÍO AL CLIENTE DE LA LECCIÓN
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        try {
            $request->validated();
            $lesson->update($request->all());
            // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
            return response()->json(['msg' => 'La clase se actualizó con éxito.', 'icon' => 'success', 'lesson' => $lesson]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        try {
            if (count($lesson->reservations) == 0) { // SI NO ESTÁ RELACIONADO A UNA O MÁS RESERVAS
                $lesson->delete();
                // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
                return response()->json([
                    'msg' => 'Se eliminó con éxito',
                    'icon' => 'success'
                ]);
            } else
                // RESPUESTA DEL SERVIDOR PARA EL CLIENTE
                return response()->json([
                    'msg' => 'NO se puede eliminar esta clase ya que está relacionado con una o más reservas',
                    'icon' => 'error'
                ], 500);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }
}
