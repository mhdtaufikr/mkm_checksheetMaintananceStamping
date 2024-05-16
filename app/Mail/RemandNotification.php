<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChecksheetFormHead;

class RemandNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $checksheet;
    public $remarks;

    public function __construct(ChecksheetFormHead $checksheet, $remarks)
    {
        $this->checksheet = $checksheet;
        $this->remarks = $remarks;
    }

    public function build()
    {
        return $this->subject('Notification: Checksheet Remanded')
                    ->view('emails.remandNotification'); // Make sure to create this view
    }
}
