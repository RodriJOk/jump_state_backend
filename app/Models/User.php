<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'surname',
        'acepted_terms',
        'password',
        'expo_push_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'expo_push_token' => 'string',
        ];
    }

    protected function exitUser($email){
        return User::where('email', $email)->first();
    }
    protected function getUserByEmail($email){
        return User::where('email', $email)->first();
    }
    protected function saveUser($data){
        $user = new User();
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->acepted_terms = $data['acepted_terms'];
        $user->email_verification_token = $data['email_verification_token'];
        $user->save();
        return $user;
    }
    protected function createUser($data){
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'created_at' => now(),
            'acepted_terms' => $data['acepted_terms'],
            'expo_push_token' => $data['expo_push_token'],
        ]);
        return $user;
    }

    /**
     * Relación con el progreso del usuario
     */
    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Relación con las puntuaciones del usuario
     */
    public function levelScores()
    {
        return $this->hasMany(LevelScore::class);
    }
    
}
