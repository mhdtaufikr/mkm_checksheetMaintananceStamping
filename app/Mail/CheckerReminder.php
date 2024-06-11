<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ChecksheetFormHead;

class CheckerReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $checksheetHead;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ChecksheetFormHead $checksheetHead)
    {
        $this->checksheetHead = $checksheetHead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reminder: Checksheet Approval Needed')
                    ->view('emails.checker_reminder');
    }
}
