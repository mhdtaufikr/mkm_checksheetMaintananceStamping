<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChecksheetFormHead; // Ensure you have the correct path to the model

class ApprovalReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $checksheetHead;

    public function __construct(ChecksheetFormHead $checksheetHead)
    {
        $this->checksheetHead = $checksheetHead;
    }

    public function build()
    {
        return $this->subject('Approval Reminder for Checksheet Maintenance Stamping')
                    ->view('emails.approvalReminder');
    }
}
