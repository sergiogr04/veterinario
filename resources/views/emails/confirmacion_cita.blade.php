<h2>Hola {{ $cita->cliente->nombre }}! 🐾</h2>
<p>Hemos recibido tu cita:</p>

<ul>
    <li><strong>Mascota:</strong> {{ $cita->mascota->nombre }}</li>
    <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</li>
    <li><strong>Hora:</strong> {{ $cita->hora }}</li>
    <li><strong>Tipo:</strong> {{ ucfirst($cita->tipo) }}</li>
</ul>

<p>Gracias por confiar en nosotros.</p>
