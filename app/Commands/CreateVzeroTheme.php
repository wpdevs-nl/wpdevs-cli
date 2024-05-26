<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CreateVzeroTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-vzero-theme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new VZero WordPress theme.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $theme_name = $this->ask('What is your theme name?');
        $theme_name_dir = str_replace(' ', '-', strtolower($theme_name));

        $this->task('Creating ' . $theme_name . ' theme...', function() use ($theme_name_dir) {
            $command = [
                'git',
                'clone',
                'https://github.com/vzeroo/vzero-theme.git',
                './' . $theme_name_dir,
            ];

            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);

                return false;
            }

            return true;
        });

        $this->task($theme_name . ' theme created successfully.', function() {
            return true;
        });
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
