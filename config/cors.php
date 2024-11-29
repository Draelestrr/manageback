<?php


    return [

        'paths' => ['api/*', 'sanctum/csrf-cookie'], // Define las rutas que aceptarán solicitudes CORS
    
        'allowed_methods' => ['*'], // Métodos HTTP permitidos ('GET', 'POST', etc. o '*')
    
        'allowed_origins' => ['http://localhost:5173'], // Orígenes permitidos (dominios o '*')
    
        'allowed_origins_patterns' => [], // Patrones de origen permitidos (si usas expresiones regulares)
    
        'allowed_headers' => ['*'], // Headers permitidos en las solicitudes
    
        'exposed_headers' => [], // Headers visibles para el frontend
    
        'max_age' => 0, // Tiempo de caché para preflight (opcional)
    
        'supports_credentials' => true, // Habilitar cookies y credenciales en las solicitudes
    ];
    

