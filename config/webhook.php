<?php

return [
    /*
    |--------------------------------------------------------------------------
    | IPs de confianza para webhooks
    |--------------------------------------------------------------------------
    |
    | Lista de IPs separadas por comas que están autorizadas a enviar webhooks
    |
    */
    'trusted_ips' => env('WEBHOOK_TRUSTED_IPS', '3.225.193.50'),
];