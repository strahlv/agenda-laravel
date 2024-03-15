<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventStartingSoon;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EventReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:event-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica usuários de eventos próximos.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = Event::where('start_date', '=', Carbon::now()->addMinutes(15)->format('Y-m-d H:i:00'))
            ->get();

        foreach ($events as $event) {
            $event->creator->notify(new EventStartingSoon($event));
            $event->participants->each(
                fn ($participant) => $participant->notify(new EventStartingSoon($event))
            );
        }

        $this->info($events->count() . ' evento(s) começam em 15 minutos (' . Carbon::now()->addMinutes(15)->format('H:i') . ')');
    }
}
