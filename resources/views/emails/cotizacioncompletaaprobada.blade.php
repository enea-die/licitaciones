@component('mail::message')

# Estimado(a)
Se ha generado una aprobación completa de una cotización en una licitación con la siguiente información:
<br><br>
ID: {{ $info->idlicitacion }}
<br>
Licitación: {{ $info->nombrelicitacion }}
<br>
Monto Licitación: {{ $info->montolicitacion }}
<br>
Empresa Licitación: {{ $info->empresalicitacion }}
<br>
Fecha Última Respuesta: {{ $info->fechasolicitud }}
<br>
Usuario: {{ $info->usuariosolicitud }}
<br><br>
Proceder a subir a la plataforma del cliente la oferta.
<br><br>
Desde ya muchas gracias.

Saludos cordiales,<br>
{{ config('app.name') }}

@endcomponent
