<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/management-login',
        '/management-logout',
        'management/user',
        'management/user/{user}',
        'management/confirm-delete',
        'management/sales',
        'management/sales/{sale}',
        'sale-send-delete-request',
        'management/mark-as-read',
        'management/mark-all-as-read',
        'management/sales-pending-to-delete-reject',
        'management/sales-pending-to-delete-destroy',
        'management/product',
        'management/product/{product}',
    ];
}
