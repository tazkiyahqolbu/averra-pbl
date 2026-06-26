<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
        Config::$curlOptions  = [CURLOPT_SSL_VERIFYPEER => false, CURLOPT_HTTPHEADER => []]; // dev only
    }

    public function createSnapToken(array $params): string
    {
        return Snap::getSnapToken($params);
    }

    public function getNotification(): Notification
    {
        return new Notification();
    }
}
