<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProgress;

class UserController extends Controller
{
    /**
     * Obtener información del usuario autenticado
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        $user = request()->user();
        
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'acepted_terms' => $user->acepted_terms,
                'must_view_introduction' => $user->must_view_introduction,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]
        ], 200);
    }

    /**
     * Obtener el progreso del usuario en el juego
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProgress()
    {
        $user = request()->user();
        
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        // Obtener todos los niveles completados
        $progress = UserProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->get();

        // Calcular estadísticas
        $levelsCompleted = $progress->pluck('level_id')->toArray();
        $currentLevel = !empty($levelsCompleted) ? max($levelsCompleted) + 1 : 1;
        $totalAttempts = UserProgress::where('user_id', $user->id)->sum('attempts');
        $totalDistance = UserProgress::where('user_id', $user->id)->sum('distance');

        return response()->json([
            'levels_completed' => $levelsCompleted,
            'current_level' => $currentLevel,
            'total_attempts' => $totalAttempts,
            'total_distance' => $totalDistance,
        ], 200);
    }

    /**
     * Guardar o actualizar el progreso de un nivel
     * 
     * @param int $levelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveProgress($levelId)
    {
        $user = request()->user();
        
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        // Validar los datos
        $validatedData = request()->validate([
            'completed' => 'required|boolean',
            'score' => 'required|integer|min:0',
            'attempts' => 'required|integer|min:0',
            'time_played' => 'required|integer|min:0',
            'difficulty' => 'required|string|in:easy,normal,hard',
        ]);

        // Buscar o crear el progreso del nivel
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'level_id' => $levelId,
            ],
            [
                'completed' => $validatedData['completed'],
                'score' => $validatedData['score'],
                'attempts' => $validatedData['attempts'],
                'time_played' => $validatedData['time_played'],
                'difficulty' => $validatedData['difficulty'],
                'distance' => request()->input('distance', 0),
            ]
        );

        return response()->json([
            'message' => 'Progreso actualizado exitosamente',
            'progress' => [
                'level_id' => $progress->level_id,
                'completed' => $progress->completed,
                'score' => $progress->score,
                'attempts' => $progress->attempts,
                'time_played' => $progress->time_played,
                'difficulty' => $progress->difficulty,
                'distance' => $progress->distance,
            ]
        ], 200);
    }
}
