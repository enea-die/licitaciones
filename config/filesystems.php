<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'adjuntoinvitaciones' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntoinvitaciones'),
            'visibility' => 'public',
        ],

        'adjuntocartarechazos' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntocartarechazos'),
            'visibility' => 'public',
        ],

        'adjuntobasestecnicas' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntobasestecnicas'),
            'visibility' => 'public',
        ],

        'adjuntovisita' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntovisita'),
            'visibility' => 'public',
        ],

        'evaluacioneconomicacotizacion' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/evaluacioneconomicacotizacion'),
            'visibility' => 'public',
        ],

        'adjunto_orden_servicio_trab_adic' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntoordenserviciotrabadic'),
            'visibility' => 'public',
        ],

        'adjuntocotizaciones' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntocotizaciones'),
            'visibility' => 'public',
        ],

        'adjuntocartagantts' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntocartagantts'),
            'visibility' => 'public',
        ],

        'adjuntoorganigramas' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntoorganigramas'),
            'visibility' => 'public',
        ],

        'adjuntopasoapasochecklist' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntopasoapasochecklist'),
            'visibility' => 'public',
        ],

        'adjuntomatrizriesgos' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntomatrizriesgos'),
            'visibility' => 'public',
        ],

        'adjuntoinformesfinales' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntoinformesfinales'),
            'visibility' => 'public',
        ],

        'adjuntocartaexcusa' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntocartaexcusa'),
            'visibility' => 'public',
        ],

        'adjuntoordencliente' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntoordencliente'),
            'visibility' => 'public',
        ],

        'adjunto_informe_tecnico_spom' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntoinformetecnicospom'),
            'visibility' => 'public',
        ],

        'adjunto_factura_has' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntofacturahas'),
            'visibility' => 'public',
        ],

        'adjunto_infome_kpi_servicio' => [
            'driver'     => 'local',
            'root'       => base_path('/extras/documentacion/adjuntoinfomekpiservicio'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
