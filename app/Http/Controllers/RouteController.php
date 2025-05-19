<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{
    public function index()
    {
        // Get all routes
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'method' => implode('|', $route->methods),
                'uri'    => $route->uri,
                'name'   => $route->getName(),
                'action' => $route->getActionName(),
            ];
        });

        return view('routes.index', compact('routes'));
    }

    public function insertRoutes()
    {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return $route->getName();
        })->filter();

        foreach ($routes as $route) {
            if ($route) {
                Permission::updateOrCreate(
                    ['route' => $route],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        return redirect()->route('routes.index')->with('success', 'Routes inserted into permissions table!');
    }

}
