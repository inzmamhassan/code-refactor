<?php

namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\FirePHPHandler;

class CustomLog
{
    public function initializeChannel($config)
    {
        $logger = new Logger($config['channel']);

        $logger->pushHandler(new StreamHandler(storage_path('logs/'.$config['type'].'/laravel-' . date('Y-m-d') . '.log'), Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());

        return $logger;
    }
}