<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF; // Make sure you have imported the PDF facade

class ChecksheetApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $checksheetHeader;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($checksheetHeader, $pdf)
    {
        $this->checksheetHeader = $checksheetHeader;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Checksheet Approved: ' . $this->checksheetHeader->document_number)
                    ->view('emails.checksheet_approval')
                    ->attachData($this->pdf->output(), 'checksheet_' . $this->checksheetHeader->document_number . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}

