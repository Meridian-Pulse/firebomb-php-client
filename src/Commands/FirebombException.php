<?php

namespace MeridianPulse\Firebomb\Commands;

use Illuminate\Console\Command;
use Exception;
use function Termwind\{render};

class FirebombException extends Command
{
    protected $signature = 'firebomb:test {--message= : The exception message to test}';
    protected $description = 'Test the Firebomb exception handling';

    public function handle()
    {
        $message = $this->option('message') ?: 'Test exception message';

        try {
            throw new Exception($message);
        } catch (Exception $e) {
            app('MeridianPulse\Firebomb\FirebombPhpExceptionLogger')->logException($e);

            // $this->info('Exception thrown and handled by Firebomb: ' . $e->getMessage());

            $message = $e->getMessage();
            $message = $e->getMessage();
            render(<<<HTML
                <div>
                    <div class="px-2 bg-red-400">🔥💣 Firebomb</div>
                    <em class="ml-1">
                    Exception thrown and handled by Firebomb: 
    HTML
            . $message . 
            <<<HTML
                    </em>
                </div>
            HTML);
        }
    }
}
