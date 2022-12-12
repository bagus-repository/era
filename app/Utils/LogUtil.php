<?php
namespace App\Utils;

use Illuminate\Support\Facades\Log;

class LogUtil
{
    /**
     * Wrapper laravel error log
     *
     * @param string $msg
     * @param \Exception|null $ex
     * @return void
     */
    public static function logError(string $msg, \Exception $ex = null)
    {
        if (config('app.env') == 'local' && $ex !== null) {
            throw $ex;
        }
        Log::error($msg);
        if ($ex !== null) {
            Log::error($ex->getTraceAsString());
        }
    }

    /**
     * Wrapper laravel info log
     *
     * @param string $msg
     * @param \Exception|null $ex
     * @return void
     */
    public static function logInfo(string $msg, \Exception $ex = null)
    {
        Log::info($msg);
        if ($ex !== null) {
            Log::info($ex->getTraceAsString());
        }
    }
}