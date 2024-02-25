
********************* Cron Job In Laravel ***********************************

1. Write Command In Terminal : php artisan make:command DemoCron --command=demo:cron


2. In app/Console/Commands/DemoCron.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\Form;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info("Cron Is Working Fine");

        $data = Form::count();

        Mail::send('mail', ['data' => $data] , function($message){
            $message->to('sagar@pearlorganisation.com')
            ->subject('Toal User From Harshit Side');

        });
        
}
}





3. In app/Console/Kernel.php

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    protected $commands = [
        Commands\DemoCron::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('demo:cron')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}




4. Run In Terminal : php artisan schedule:run

5. Check Your Command Run Or Not In Log File : storage/logs/laravel.php
