<?php

namespace Exoticpixels\Firebomb;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class FirebombExceptionHandler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        // Your custom logic to log the exception
        $logger = resolve(FirebombPhpExceptionLogger::class);
        $logger->logException($exception);
    }
}
