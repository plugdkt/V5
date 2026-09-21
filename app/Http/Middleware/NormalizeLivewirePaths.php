<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NormalizeLivewirePaths
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if the response contains HTML content and is modifyable
        if (method_exists($response, 'getContent') && method_exists($response, 'setContent')) {
            $contentType = $response->headers->get('Content-Type', '');
            if (str_contains($contentType, 'text/html')) {
                $content = $response->getContent();
                $assetUrl = config('app.asset_url', '');
                
                if ($assetUrl && str_contains($content, 'data-update-uri="/livewire/update"')) {
                    $newContent = str_replace(
                        'data-update-uri="/livewire/update"',
                        'data-update-uri="' . rtrim($assetUrl, '/') . '/livewire/update"',
                        $content
                    );
                    $response->setContent($newContent);
                }
            }
        }

        return $response;
    }
}
