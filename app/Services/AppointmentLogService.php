<?php

namespace App\Services;

use App\Models\AppointmentLog;

class AppointmentLogService {

    public static function log($data)
    {
        AppointmentLog::create($data);
    }
}


