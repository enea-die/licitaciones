@component('mail::message')

# Estimado(a)
Se ha autorizado la participación de la siguiente licitación y sus fechas son las siguientes:
<br><br>
ID: {{ $info->idlicitacion }}
<br>
Licitación: {{ $info->nombrelicitacion }}
<br>
Fecha Visita: {{ $info->fechavisita }}
<br>
Fecha Preguntas y Respuestas: {{ $info->fechapreguntayrespuestas }}
<br>
Fecha Envio Propuesta: {{ $info->fechaenviopropuesta }}
<br>
Usuario: {{ $info->usuariosolicitud }}
<br><br>
Desde ya muchas gracias.

Saludos cordiales,<br>
{{ config('app.name') }}

@endcomponent
