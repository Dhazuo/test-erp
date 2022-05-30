<?php

namespace App\Http\Middleware;

use App\Models\Sale;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $admin = null, $manager = null, $seller = 'seller')
    {
        $user = Auth::user();
        $uri = $request->route()->action["as"];

        if ($request->routeIs('management.product*')) {
            if ($user->hasRole($seller) && !$request->routeIs('management.product.index')) {
                abort(401);
            }
        }
        if ($request->routeIs('management.user*')) {
            if ($user->hasRole($seller)) {
                abort(401);
            }
            if ($user->hasRole($manager) && (
                    $uri == 'management.user.edit' ||
                    $uri == 'management.user.show' ||
                    $uri == 'management.user.update' ||
                    $uri == 'management.user.destroy')
            )
            {
                $params = $request->route()->parameters();
                $id = $params["user"];
                $id = (int) $id;
                $find = User::where('id', $id)->first();
                if (!$find->hasRole($seller)) {
                    abort(401);
                }
            }
        }
        if ($request->routeIs('management.sales*')) {
            if ($user->hasRole($seller) && (
                    $uri == 'management.sales.edit' ||
                    $uri == 'management.sales.show' ||
                    $uri == 'management.sales.update' ||
                    $uri == 'management.sales.destroy'
                )
            ) {
                if($uri == 'management.sales.destroy'){
                    abort(401);
                }
                $params = $request->route()->parameters();
                $id = $params["sale"];
                $id = (int) $id;
                $find = Sale::where('id', $id)->first();
                if ($find->seller_id != $user->id) {
                    abort(401);
                }
            }
        }
        if ($request->routeIs('management.sales.pending_to_delete*')){
            if ($user->hasRole($seller)) {
                abort(401);
            }
        }

        return $next($request);
    }
}
