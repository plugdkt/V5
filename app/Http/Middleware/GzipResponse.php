<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

class GzipResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if browser accepts gzip and zlib extension is available
        if (!function_exists('gzencode') || !str_contains($request->header('Accept-Encoding', ''), 'gzip')) {
            return $response;
        }

        // Don't double compress
        if ($response->headers->has('Content-Encoding')) {
            return $response;
        }

        // Don't compress streamed responses
        if ($response instanceof StreamedResponse) {
            return $response;
        }

        // Handle BinaryFileResponse (e.g. Livewire Javascript files or static assets served via PHP)
        if ($response instanceof BinaryFileResponse) {
            $file = $response->getFile();
            $mime = $file->getMimeType();
            $ext = strtolower($file->getExtension());

            // Only compress text-based file assets
            $compressible = in_array($ext, ['js', 'css', 'html', 'json', 'svg', 'xml', 'txt']) ||
                           str_contains($mime, 'javascript') ||
                           str_contains($mime, 'text') ||
                           str_contains($mime, 'json') ||
                           str_contains($mime, 'xml');

            if (!$compressible) {
                return $response;
            }

            $content = file_get_contents($file->getPathname());
            if ($content === false || strlen($content) < 1024) {
                return $response;
            }

            $compressed = gzencode($content, 6);
            if ($compressed === false) {
                return $response;
            }

            $headers = $response->headers->all();
            $headers['content-encoding'] = 'gzip';
            $headers['vary'] = 'Accept-Encoding';
            $headers['content-length'] = (string) strlen($compressed);

            return new Response($compressed, $response->getStatusCode(), $headers);
        }

        // Handle standard Response
        $content = $response->getContent();
        if ($content === false || strlen($content) < 1024) {
            return $response;
        }

        $compressed = gzencode($content, 6);
        if ($compressed !== false && strlen($compressed) < strlen($content)) {
            $response->setContent($compressed);
            $response->headers->set('Content-Encoding', 'gzip');
            $response->headers->set('Vary', 'Accept-Encoding');
            $response->headers->set('Content-Length', (string) strlen($compressed));
        }

        return $response;
    }
}
