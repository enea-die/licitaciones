@component('mail::message')

# Estimado(a)
Se ha generado un registro de solicitud de centro de costo con la siguiente información:
<br><br>
ID: {{ $info->idlicitacion }}
<br>
Licitación: {{ $info->nombrelicitacion }}
<br>
Fecha Solicitud: {{ $info->fechasolicitud }}
<br>
Usuario: {{ $info->usuariosolicitud }}
<br><br>
Desde ya muchas gracias.

Saludos cordiales,<br>
{{ config('app.name') }}

@endcomponent
