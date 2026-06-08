<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Política de privacidad — {{ config('app.name', 'Juego') }}</title>
    <style>
        :root {
            color-scheme: light dark;
            --bg: #f5f5f4;
            --card: #ffffff;
            --text: #1b1b18;
            --muted: #706f6c;
            --border: #e3e3e0;
            --accent: #f53003;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0a0a0a;
                --card: #161615;
                --text: #ededec;
                --muted: #a1a09a;
                --border: #3e3e3a;
                --accent: #ff4433;
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

        h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .updated {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        h2 {
            font-size: 1.1rem;
            margin: 1.75rem 0 0.75rem;
        }

        p, li {
            margin-bottom: 0.75rem;
            color: var(--text);
        }

        ul {
            padding-left: 1.25rem;
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
        <h1>Política de privacidad</h1>
        <p class="updated">Última actualización: {{ now()->format('d/m/Y') }}</p>

        <p>
            Esta política describe cómo {{ config('app.name', 'el juego') }} recopila, utiliza y protege
            la información personal de los usuarios que utilizan nuestra aplicación y servicios asociados.
        </p>

        <h2>1. Responsable del tratamiento</h2>
        <p>
            El responsable del tratamiento de tus datos personales es el titular de {{ config('app.name', 'el juego') }}.
            Para consultas relacionadas con privacidad, puedes contactarnos a través de los canales oficiales
            de soporte indicados en la aplicación.
        </p>

        <h2>2. Datos que recopilamos</h2>
        <p>Podemos recopilar la siguiente información cuando creas una cuenta o utilizas el juego:</p>
        <ul>
            <li>Nombre y apellido.</li>
            <li>Dirección de correo electrónico.</li>
            <li>Contraseña (almacenada de forma cifrada).</li>
            <li>Progreso del juego, puntuaciones, intentos y clasificaciones.</li>
            <li>Datos técnicos necesarios para el funcionamiento del servicio (por ejemplo, tokens de sesión).</li>
        </ul>

        <h2>3. Finalidad del tratamiento</h2>
        <p>Utilizamos tus datos para:</p>
        <ul>
            <li>Crear y gestionar tu cuenta de usuario.</li>
            <li>Permitir el acceso seguro al juego y a sus funciones.</li>
            <li>Guardar tu progreso, récords y posición en las tablas de clasificación.</li>
            <li>Enviar comunicaciones relacionadas con la cuenta, cuando sea necesario (por ejemplo, recuperación de contraseña).</li>
            <li>Mejorar la experiencia de juego y la estabilidad del servicio.</li>
        </ul>

        <h2>4. Base legal</h2>
        <p>
            El tratamiento de tus datos se basa en la ejecución del contrato al utilizar el juego,
            tu consentimiento al aceptar los términos y esta política, y, en su caso, el interés legítimo
            en mantener un servicio seguro y funcional.
        </p>

        <h2>5. Conservación de los datos</h2>
        <p>
            Conservamos tus datos mientras mantengas una cuenta activa o sea necesario para prestar el servicio.
            Si solicitas la eliminación de tu cuenta, eliminaremos o anonimizaremos tus datos personales,
            salvo que debamos conservarlos por obligación legal.
        </p>

        <h2>6. Compartición de datos</h2>
        <p>
            No vendemos tus datos personales. Podemos compartir información únicamente con proveedores
            que nos ayudan a operar el servicio (por ejemplo, alojamiento o infraestructura),
            siempre bajo obligaciones de confidencialidad y seguridad.
        </p>

        <h2>7. Seguridad</h2>
        <p>
            Aplicamos medidas técnicas y organizativas razonables para proteger tu información,
            incluyendo el cifrado de contraseñas y el uso de mecanismos de autenticación segura.
        </p>

        <h2>8. Tus derechos</h2>
        <p>Según la normativa aplicable, puedes ejercer los siguientes derechos:</p>
        <ul>
            <li>Acceder a tus datos personales.</li>
            <li>Rectificar datos inexactos o incompletos.</li>
            <li>Solicitar la supresión de tus datos.</li>
            <li>Oponerte o limitar determinados tratamientos.</li>
            <li>Solicitar la portabilidad de tus datos, cuando corresponda.</li>
        </ul>
        <p>
            Para ejercer estos derechos, contacta con nosotros a través de los canales oficiales de soporte.
        </p>

        <h2>9. Menores de edad</h2>
        <p>
            El juego no está dirigido a menores de edad sin el consentimiento de sus padres o tutores legales.
            Si detectamos que se han recopilado datos de un menor sin autorización, procederemos a eliminarlos.
        </p>

        <h2>10. Cambios en esta política</h2>
        <p>
            Podemos actualizar esta política de privacidad ocasionalmente. Publicaremos la versión vigente
            en esta misma página e indicaremos la fecha de la última actualización.
        </p>

        <footer>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Juego') }}. Todos los derechos reservados.</p>
        </footer>
    </main>
</body>
</html>
