<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckValidUri
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $validUris = config('global.VALID_URIS');
        $prefix = '/api/v1/';
        $count = substr_count($request->url(), '/');
        $url = $request->url();
        /** START - CHECK URI with ID */
        $searchID = explode('/', $url);
        $id = (int)end($searchID);
        if($id !== 0) $url = dirname($url);
        /** END - CHECK URI with ID */
        $route = substr($url, strpos($url, $prefix) + strlen($prefix));
        // dd($route, $validUris , $url);
        if(!in_array($route, $validUris)) {
            return response()->json(['error' => 'Invalid URI'], 404);
        }
        return $next($request);
    }
}
