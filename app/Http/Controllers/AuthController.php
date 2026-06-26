<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\MailgunService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\PasswordBroker;

class AuthController extends Controller{
    public function register(){
        $data = request()->all();
        $rules = [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'acepted_terms' => 'required|in:true',
            'expo_push_token' => 'nullable|string',
        ];  
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'surname.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'acepted_terms.required' => 'Debe aceptar los términos y condiciones.',
            'expo_push_token.string' => 'El token de expo push debe ser una cadena de texto.',
        ];

        $validatedData = request()->validate($rules, $messages);
        if (!$validatedData) {
            return response()->json([
                'message' => 'Datos inválidos. Por favor, revise los campos. ' . implode(', ', $messages)
            ], 422);
        }

        $user = User::createUser([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'acepted_terms' => $data['acepted_terms'],
            'expo_push_token' => $data['expo_push_token'] ?? null,
        ]);

        if(!$user){
            return response()->json([
                'message' => 'Error al crear el usuario'
            ], 500);
        }

        return response()->json([
            'message' => 'Usuario creado exitosamente'
        ], 200);
    }
    public function login(){
        if (!Auth::attempt(request()->only('email', 'password'))) {
            return response()->json(
                [
                    'message' => 'Credenciales inválidas. Por favor, inténtelo de nuevo.'
                ], 
                401
            );
        }

        $user = User::where('email', request()->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
    public function existingUser(){
        $validatedData = request()->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (!Auth::attempt($validatedData)) {
            return response()->json(
                [
                    'message' => 'Credenciales inválidas. Por favor, inténtelo de nuevo.'
                ], 
                401
            );
        }
        $user = Auth::user();
        if (! $user instanceof User) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }
    public function forgetPassword(MailgunService $mailgun){
        $data = request()->all();
        $rules = [
            'email' => 'required|email',
        ];
        $messages = [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser un email válido',
        ];
        $validator = validator()->make($data, $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $email = request()->email;
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = $this->createPasswordResetToken($user);
            return response()->json([
                'status' => 'success',
                'token' => $token,
                'message' => 'Se ha enviado un correo para recuperar la contraseña'
            ], 200);
            $resetLink = rtrim(config('app.password_reset_url'), '/')
                . '?token=' . $token
                . '&email=' . urlencode($email);

            $html = view('mail.password-reset', [
                'name' => $user->name,
                'subject' => 'Solicitud de reestablecimiento de contraseña',
                'resetLink' => $resetLink,
                'expiresInMinutes' => config('auth.passwords.users.expire', 60),
            ])->render();

            try {
                $mailgun->send(
                    $email,
                    'Solicitud de reestablecimiento de contraseña',
                    $html,
                    "Usa este enlace para restablecer tu contraseña: {$resetLink}"
                );
            } catch (\Throwable $e) {
                Log::error('Error al enviar email de recuperación de contraseña', [
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al enviar el email',
                ], 500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Se ha enviado un correo para recuperar la contraseña'
        ], 200);
    }
    public function changePassword(){
        $data = request()->all();
        $rules = [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ];
        $messages = [
            'current_password.required' => 'La contraseña actual es requerida',
            'new_password.required' => 'La nueva contraseña es requerida',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide',
        ];
        $validator = validator()->make($data, $rules, $messages);
        if ($validator->fails()) {
        return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 400);
        }

        // 2. Obtener el usuario desde el sistema de Auth (basado en el token)
        $user = Auth::user();

        // 3. Verificar contraseña actual
        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'La contraseña actual es incorrecta'], 401);
        }

        $user = User::find($user->id);
        
        // 4. Actualizar y Guardar
        $user->update([
            'password' => Hash::make($data['new_password'])
        ]);

        return response()->json(['status' => 'success', 'message' => 'Contraseña actualizada'], 200);
    }
    public function logout(){
        request()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ], 200);
    }
    public function me(){
        return response()->json([
            'user' => request()->user()
        ], 200);
    }

    private function createPasswordResetToken(User $user): string
    {
        $broker = Password::broker();

        if (! $broker instanceof PasswordBroker) {
            throw new \RuntimeException('Password broker no disponible.');
        }

        return $broker->createToken($user);
    }
}