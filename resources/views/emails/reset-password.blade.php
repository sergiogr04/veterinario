<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablece tu contraseña</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: sans-serif; color: #1f2937;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <img src="{{ asset('images/logo-clinica.webp') }}" alt="Clínica San Lorenzo" style="height: 80px;">
            </td>
        </tr>
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; padding: 32px;">
                    <tr>
                        <td>
                            <h2 style="color: #1f2937;">Hola 👋</h2>
                            <p style="margin-bottom: 24px;">Has solicitado restablecer tu contraseña. Haz clic en el botón de abajo para continuar:</p>
                            <p style="text-align: center; margin: 24px 0;">
                                <a href="{{ $url }}"
                                   style="background-color: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
                                    Restablecer contraseña
                                </a>
                            </p>
                            <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
                            <p style="margin-top: 32px;">Saludos,<br><strong>Clínica San Lorenzo 🐾</strong></p>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #6b7280; margin-top: 24px;">
                    © 2025 Clínica San Lorenzo. Todos los derechos reservados.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
