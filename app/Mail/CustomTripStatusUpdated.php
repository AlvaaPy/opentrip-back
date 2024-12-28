<?php

namespace App\Mail;

use App\Models\CustomTrip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomTripStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $customTrip;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param CustomTrip $customTrip
     * @param string $status
     * @return void
     */
    public function __construct(CustomTrip $customTrip, string $status)
    {
        $this->customTrip = $customTrip;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Status Custom Trip Anda Diperbarui')
                    ->view('emails.custom_trip_status_updated');
    }
}
