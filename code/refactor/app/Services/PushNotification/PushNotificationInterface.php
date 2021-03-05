<?php

namespace App\Services\PushNotification;

interface PushNotificationInterface
{
    /**
     * @param Request $file
     * @param string $path
     * @return string
     */
    public function sendNotification($users, $job_id, $data, $msg, $is_need_delay);
}
