<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminación de cuenta — {{ config('app.name', 'Juego') }}</title>
    <style>
        :root {
            color-scheme: light dark;
            --bg: #f5f5f4;
            --card: #ffffff;
            --text: #1b1b18;
            --muted: #706f6c;
            --border: #e3e3e0;
            --accent: #f53003;
            --highlight: #fff8f6;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0a0a0a;
                --card: #161615;
                --text: #ededec;
                --muted: #a1a09a;
                --border: #3e3e3a;
                --accent: #ff4433;
                --highlight: #1d0002;
            }
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            padding: 2rem 1rem 3rem;
        }

        .container {
            max-width: 720px;
            margin: 0 auto;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 2rem 1.5rem;
        }

        .app-name {
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 0.75rem;
        }

        h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .intro {
            color: var(--muted);
            margin-bottom: 2rem;
        }

        h2 {
            font-size: 1.1rem;
            margin: 1.75rem 0 0.75rem;
        }

        p, li {
            margin-bottom: 0.75rem;
        }

        ul, ol {
            padding-left: 1.25rem;
        }

        .steps {
            background: var(--highlight);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 1.25rem 1.25rem 1.25rem 1rem;
            margin: 1rem 0 1.5rem;
        }

        .steps ol {
            margin-bottom: 0;
        }

        .steps li {
            margin-bottom: 0.85rem;
        }

        .steps li:last-child {
            margin-bottom: 0;
        }

        .email-link {
            font-weight: 600;
            word-break: break-all;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0 1.5rem;
            font-size: 0.95rem;
        }

        th, td {
            border: 1px solid var(--border);
            padding: 0.75rem;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: var(--highlight);
        }

        a {
            color: var(--accent);
        }

        footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            font-size: 0.9rem;
            color: var(--muted);
        }
    </style>
</head>
<body>
    <main class="container">
        <p class="app-name">{{ config('app.name', 'Juego') }}</p>
        <h1>Eliminación de cuenta y datos</h1>
        <p class="intro">
            En esta página puedes solicitar la eliminación de tu cuenta de {{ config('app.name', 'el juego') }}
            y conocer qué datos se borran o conservan.
        </p>

        <h2>Pasos para solicitar la eliminación de tu cuenta</h2>
        <div class="steps">
            <ol>
                <li>
                    Envía un correo electrónico a
                    <a class="email-link" href="mailto:{{ config('mail.from.address') }}?subject=Solicitud%20de%20eliminaci%C3%B3n%20de%20cuenta%20-%20{{ rawurlencode(config('app.name', 'Juego')) }}">
                        {{ config('mail.from.address') }}
                    </a>
                    con el asunto: <strong>Solicitud de eliminación de cuenta</strong>.
                </li>
                <li>
                    En el mensaje, indica el <strong>correo electrónico</strong> con el que te registraste en
                    {{ config('app.name', 'el juego') }}.
                </li>
                <li>
                    Opcionalmente, puedes indicar el motivo de la solicitud. No es obligatorio para procesarla.
                </li>
                <li>
                    Recibirás una confirmación por correo cuando tu solicitud sea recibida y, una vez completada
                    la eliminación, un aviso final de que tu cuenta y datos asociados han sido eliminados.
                </li>
                <li>
                    El proceso puede tardar hasta <strong>30 días</strong> desde la recepción de la solicitud.
                </li>
            </ol>
        </div>

        <h2>Datos que se eliminan</h2>
        <p>Al eliminar tu cuenta, borraremos de forma permanente:</p>
        <ul>
            <li>Datos de perfil: nombre, apellido y correo electrónico.</li>
            <li>Credenciales de acceso (contraseña cifrada y tokens de sesión).</li>
            <li>Progreso del juego (niveles completados, intentos y distancia).</li>
            <li>Puntuaciones, récords y tu posición en las tablas de clasificación.</li>
            <li>Token de notificaciones push, si lo hubieras registrado.</li>
        </ul>

        <h2>Datos que pueden conservarse</h2>
        <table>
            <thead>
                <tr>
                    <th>Tipo de dato</th>
                    <th>¿Se conserva?</th>
                    <th>Plazo / motivo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Registros técnicos y de seguridad (logs del servidor)</td>
                    <td>Sí, de forma limitada</td>
                    <td>Hasta 90 días, para prevenir fraudes y garantizar la seguridad del servicio.</td>
                </tr>
                <tr>
                    <td>Copias de seguridad del sistema</td>
                    <td>Sí, temporalmente</td>
                    <td>Hasta 30 días adicionales, tras lo cual se sobrescriben automáticamente.</td>
                </tr>
                <tr>
                    <td>Datos exigidos por ley</td>
                    <td>Sí, si aplica</td>
                    <td>Únicamente cuando una normativa legal lo requiera.</td>
                </tr>
                <tr>
                    <td>Estadísticas agregadas y anónimas</td>
                    <td>Puede conservarse</td>
                    <td>Datos que no permiten identificarte personalmente (por ejemplo, totales de uso).</td>
                </tr>
            </tbody>
        </table>

        <h2>Información adicional</h2>
        <p>
            Si solo deseas dejar de usar el juego sin eliminar la cuenta, puedes cerrar sesión desde la aplicación.
            Para conocer cómo tratamos tus datos en general, consulta nuestra
            <a href="{{ route('privacy-policy') }}">política de privacidad</a>.
        </p>

        <footer>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Juego') }}. Todos los derechos reservados.</p>
        </footer>
    </main>
</body>
</html>
