<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Ponencia Registrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #4154f1;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }

        .credentials-box {
            background-color: white;
            border-left: 4px solid #4154f1;
            padding: 15px;
            margin: 20px 0;
        }

        .credentials-box h3 {
            margin-top: 0;
            color: #4154f1;
        }

        .credential-item {
            margin: 10px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 3px;
        }

        .credential-label {
            font-weight: bold;
            color: #666;
        }

        .credential-value {
            font-size: 16px;
            color: #333;
            font-family: monospace;
        }

        .ponencia-info {
            background-color: white;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            background-color: #4154f1;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }

        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>¡Bienvenido!</h1>
        <p>Tu ponencia ha sido registrada exitosamente</p>
    </div>

    <div class="content">
        <h2>Hola {{ $user->name }},</h2>

        <p>Nos complace confirmar que tu ponencia ha sido registrada en nuestro sistema.</p>

        <div class="ponencia-info">
            <h3>📋 Detalles de tu Ponencia</h3>
            <p><strong>Título:</strong> {{ $ponencia->titulo }}</p>
            <p><strong>Descripción:</strong> {{ $ponencia->descripcion }}</p>
            <p><strong>Fecha:</strong> {{ $ponencia->fecha_ponencia->format('d/m/Y') }}</p>
            <p><strong>Horario:</strong> {{ substr($ponencia->horario_ponencia, 0, 5) }}</p>
            <p><strong>Nivel:</strong> {{ ucfirst($ponencia->nivel) }}</p>
        </div>

        <div class="credentials-box">
            <h3>🔐 Credenciales de Acceso</h3>
            <p>Hemos creado una cuenta para que puedas acceder al sistema y subir los materiales de tu ponencia.</p>

            <div class="credential-item">
                <div class="credential-label">Email:</div>
                <div class="credential-value">{{ $user->email }}</div>
            </div>

            <div class="credential-item">
                <div class="credential-label">Contraseña Temporal:</div>
                <div class="credential-value">{{ $password }}</div>
            </div>
        </div>

        <div class="warning">
            <strong>⚠️ Importante:</strong> Por seguridad, te recomendamos cambiar tu contraseña después del primer
            inicio de sesión.
        </div>

        <div style="text-align: center;">
            <a href="{{ $urlLogin }}" class="button">Acceder al Sistema</a>
        </div>

        <h3>📎 Próximos Pasos</h3>
        <ol>
            <li>Inicia sesión con las credenciales proporcionadas</li>
            <li>Sube el material de tu ponencia (PDF o PowerPoint)</li>
            <li>Revisa los detalles de tu ponencia</li>
            <li>Espera la confirmación de aprobación</li>
        </ol>

        <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>

        <p>¡Esperamos verte pronto!</p>
    </div>

    <div class="footer">
        <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        <p>&copy; {{ date('Y') }} - Todos los derechos reservados</p>
    </div>
</body>

</html>
