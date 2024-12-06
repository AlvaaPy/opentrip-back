<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CancelPendingReservations extends Command
{
    protected $signature = 'reservations:cancel';
    protected $description = 'Cancel pending reservations after 1 minutes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Command reservations:cancel executed');

        $expiredReservations = Reservation::where('status', 'Pending')
            ->where('created_at', '<', Carbon::now()->subMinutes(1))
            ->update(['status' => 'Dibatalkan']);

        $this->info("Expired reservations canceled: {$expiredReservations}");
    }
}
