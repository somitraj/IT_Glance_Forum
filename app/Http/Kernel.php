<?php

namespace IT_Glance_Forum\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \IT_Glance_Forum\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \IT_Glance_Forum\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth.admin'=>\IT_Glance_Forum\Http\Middleware\checkAdmin::class,
        'auth.intern'=>\IT_Glance_Forum\Http\Middleware\checkIntern::class,
        'auth.submentor'=>\IT_Glance_Forum\Http\Middleware\checkSubMentor::class,
        'auth.mentor'=>\IT_Glance_Forum\Http\Middleware\checkMentor::class,
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \IT_Glance_Forum\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'admin.role'=> \IT_Glance_Forum\Http\Middleware\UserCheck::class,
        'intern.role'=> \IT_Glance_Forum\Http\Middleware\UserCheck::class,
        'mentor.role'=> \IT_Glance_Forum\Http\Middleware\UserCheck::class,
        'submentor.role'=> \IT_Glance_Forum\Http\Middleware\UserCheck::class,
    ];
}
