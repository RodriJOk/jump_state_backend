<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelScore;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    /**
     * Obtener el leaderboard global
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGlobalLeaderboard()
    {
        $limit = request()->input('limit', 100);
        $offset = request()->input('offset', 0);

        // Obtener el total de puntos por usuario
        $rankings = LevelScore::select('user_id', DB::raw('SUM(best_score) as total_score'))
            ->groupBy('user_id')
            ->havingRaw('SUM(best_score) > 0')
            ->orderByRaw('SUM(best_score) DESC')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Formatear los rankings con información del usuario
        $formattedRankings = [];
        $rank = $offset + 1;
        
        foreach ($rankings as $ranking) {
            $user = User::find($ranking->user_id);
            if ($user) {
                $formattedRankings[] = [
                    'rank' => $rank,
                    'user_name' => $user->name . ' ' . $user->surname,
                    'total_score' => (int) $ranking->total_score,
                    'avatar' => null, // Puedes agregar un campo de avatar después
                ];
                $rank++;
            }
        }

        // Obtener el ranking del usuario autenticado
        $currentUser = request()->user();
        $userRank = null;
        
        if ($currentUser) {
            $userTotalScore = LevelScore::where('user_id', $currentUser->id)
                ->sum('best_score');
            
            $userRank = LevelScore::select('user_id', DB::raw('SUM(best_score) as total_score'))
                ->groupBy('user_id')
                ->havingRaw('SUM(best_score) > ?', [$userTotalScore])
                ->count() + 1;
        }

        // Total de jugadores con al menos un punto
        $totalPlayers = LevelScore::where('best_score', '>', 0)
            ->distinct()
            ->count('user_id');

        return response()->json([
            'rankings' => $formattedRankings,
            'user_rank' => $userRank,
            'total_players' => $totalPlayers,
        ], 200);
    }

    /**
     * Obtener el leaderboard de un nivel específico
     * 
     * @param int $levelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLevelLeaderboard($levelId)
    {
        $limit = request()->input('limit', 100);
        $offset = request()->input('offset', 0);

        // Obtener los mejores puntajes para el nivel
        $rankings = LevelScore::where('level_id', $levelId)
            ->where('best_score', '>', 0)
            ->orderByDesc('best_score')
            ->orderBy('updated_at')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Formatear los rankings
        $formattedRankings = [];
        $rank = $offset + 1;
        
        foreach ($rankings as $ranking) {
            $user = User::find($ranking->user_id);
            if ($user) {
                $formattedRankings[] = [
                    'rank' => $rank,
                    'user_name' => $user->name . ' ' . $user->surname,
                    'score' => $ranking->best_score,
                    'mode' => $ranking->mode,
                    'completed' => $ranking->completed,
                    'avatar' => null,
                ];
                $rank++;
            }
        }

        // Obtener el ranking del usuario autenticado para este nivel
        $currentUser = request()->user();
        $userRank = null;
        
        if ($currentUser) {
            $userScore = LevelScore::where('user_id', $currentUser->id)
                ->where('level_id', $levelId)
                ->first();
            
            if ($userScore && $userScore->best_score > 0) {
                $userRank = LevelScore::where('level_id', $levelId)
                    ->where('best_score', '>', $userScore->best_score)
                    ->count() + 1;
            }
        }

        // Total de jugadores en este nivel con puntaje
        $totalPlayers = LevelScore::where('level_id', $levelId)
            ->where('best_score', '>', 0)
            ->count();

        return response()->json([
            'level_id' => (int) $levelId,
            'rankings' => $formattedRankings,
            'user_rank' => $userRank,
            'total_players' => $totalPlayers,
        ], 200);
    }
}
