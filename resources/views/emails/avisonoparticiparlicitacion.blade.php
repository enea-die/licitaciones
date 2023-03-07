@component('mail::message')

# Estimado(a)
Se ha generado un registro de solicitud de no participar en una licitación con la siguiente información:
<br><br>
ID: {{ $info->idlicitacion }}
<br>
Licitación: {{ $info->nombrelicitacion }}
<br>
Motivos: {{ $info->text_motivos }}
<br>
Observación: {{ $info->descripcion }}
<br>
Fecha Solicitud: {{ $info->fechasolicitud }}
<br>
Usuario: {{ $info->usuariosolicitud }}
<br><br>
Desde ya muchas gracias.

Saludos cordiales,<br>
{{ config('app.name') }}

@endcomponent
