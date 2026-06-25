<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.6; color: #1b1b18;">
    <p>Hola{{ $name ? ' ' . $name : '' }},</p>

    <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta en <strong>{{ config('app.name', 'JumpState') }}</strong>.</p>

    <p>
        <a href="{{ $resetLink }}" style="display: inline-block; padding: 10px 16px; background: #f53003; color: #fff; text-decoration: none; border-radius: 4px;">
            Restablecer contraseña
        </a>
    </p>

    <p>Si el botón no funciona, copia y pega este enlace en tu navegador:</p>
    <p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>

    <p>Este enlace expirará en {{ $expiresInMinutes }} minutos.</p>

    <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>

    <p>— {{ config('app.name', 'JumpState') }}</p>
</body>
</html>
