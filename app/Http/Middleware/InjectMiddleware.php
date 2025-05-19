<?php


namespace App\Http\Middleware;

use App\Models\Addon_hook;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class InjectMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->isStarted()) {
            session()->start();
        }

        $response = $next($request);

        // Skip if it's not an HTML response
        $contentType = $response->headers->get('Content-Type');
        if (stripos($contentType, 'text/html') === false) {
            return $response;
        }

        $originalContent = $response->getContent();

        // Skip DOM parsing if the content is:
        // - empty
        // - pure number
        // - plain text (no tags)
        if (
            trim($originalContent) === '' ||
            is_numeric(trim($originalContent)) ||
            strip_tags($originalContent) === trim($originalContent)
        ) {
            return $response;
        }

        $currentRouteName = Route::currentRouteName();
        $components = $this->getActiveComponents($currentRouteName);

        if ($components->isEmpty()) {
            return $response;
        }

        $dom = $this->loadHtmlToDom($originalContent);
        if (!$dom) {
            return $response;
        }

        $errors = $this->injectComponentsIntoDom($dom, $components);

        $modifiedContent = $dom->saveHTML();

        if ($modifiedContent !== $originalContent) {
            $response->setContent($modifiedContent);
        }

        if (!empty($errors)) {
            Session::flash('component_errors', $errors);
        }

        return $response;
    }


    private function shouldSkipInjection(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');
        return $contentType !== 'text/html; charset=UTF-8';
    }

    private function getActiveComponents(string $routeName)
    {
        return Addon_hook::whereHas('addon', fn($q) => $q->where('status', 1))
            ->where(function ($query) use ($routeName) {
                $query->where('app_route', $routeName)
                    ->orWhere('app_route', 'addon.any')
                    ->orWhere('app_route', 'like', 'addon');
            })
            ->with('addon')
            ->get();
    }

    private function loadHtmlToDom(string $content): ?\DOMDocument
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;

        if (@$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
            return $dom;
        }

        libxml_clear_errors();
        return null;
    }

    private function injectComponentsIntoDom(\DOMDocument $dom, $components): array
    {
        $errors = [];

        foreach ($components as $component) {
            $domConfig = json_decode($component->dom, true);

            if (!$domConfig) {
                $errors[] = "Invalid or missing DOM config for addon: {$component->addon->title}";
                continue;
            }

            $route = Route::getRoutes()->getByName($component->addon_route);
            if (!$route) {
                $errors[] = "Route '{$component->addon_route}' not found.";
                continue;
            }

            $parentElement = $dom->getElementById($domConfig['parent'] ?? '');
            if (!$parentElement) {
                $errors[] = "Parent element '{$domConfig['parent']}' not found in DOM.";
                continue;
            }

            $renderedComponent = App::call($route->getAction('uses'));

            if (!trim($renderedComponent)) {
                continue;
            }

            $fragment = $dom->createDocumentFragment();
            @$fragment->appendXML($renderedComponent);

            if ($fragment->hasChildNodes()) {
                if (($domConfig['position'] ?? 'inside') === 'inside') {
                    $parentElement->appendChild($fragment);
                } else {
                    $parentElement->parentNode->insertBefore($fragment, $parentElement->nextSibling);
                }
            }
        }

        return $errors;
    }
}
