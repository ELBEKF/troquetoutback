<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * 🌍 Middlewares globaux (appliqués à toutes les requêtes HTTP)
     */
    protected $middleware = [
        // Tu peux en ajouter ici si besoin plus tard
    ];

    /**
     * 🧱 Groupes de middlewares (pour les routes 'web' et 'api')
     */
    protected $middlewareGroups = [
        'web' => [
            // Vide pour l’instant
        ],

        'api' => [
            // Tu peux ajouter ici des middlewares globaux à ton API (ex: 'throttle:api')
        ],
    ];

    /**
     * 🧩 Middlewares individuels utilisables par alias dans les routes
     */
    protected $routeMiddleware = [
        // 👉 Ton middleware custom
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}