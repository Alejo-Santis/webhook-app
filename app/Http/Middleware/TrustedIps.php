<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrustedIps
{
    /**
     * Lista de IPs confiables (configurable desde .env)
     *
     * @var array
     */
    protected $trustedIps;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Obtener IPs confiables desde la configuración
        $this->trustedIps = explode(',', config('webhook.trusted_ips', '3.225.193.50'));
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener IP del cliente
        $clientIp = $request->ip();

        // Si es una IP de Cloudflare, usar la IP original
        if ($request->header('CF-Connecting-IP')) {
            $clientIp = $request->header('CF-Connecting-IP');
        }

        // Verificar si la IP está en la lista de confianza
        if (!in_array($clientIp, $this->trustedIps)) {
            Log::warning("Intento de acceso no autorizado desde IP: {$clientIp}");
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
