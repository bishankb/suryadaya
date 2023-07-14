<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewerMailMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $viewer_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public function __construct($viewer_message)
    {
        $this->viewer_message = $viewer_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.viewer-mail')
                    ->subject('New message from Contact Us Form');
    }
}