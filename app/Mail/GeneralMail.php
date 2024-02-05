<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $view;
    public $body;
    public $data;
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $view, $body, $data, $file = null)
    {
        $this->subject = $subject;
        $this->view = $view;
        $this->body = $body;
        $this->data = $data;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->file) {
            $this->subject($this->subject)
                        ->view($this->view)
                        ->with([
                            'data' => $this->data
                        ])
                        ->attach(storage_path('app/'.$this->file));
        }

        return $this->subject($this->subject)
                    ->view($this->view)
                    ->with([
                        'title' => $this->subject,
                        'data' => $this->data,
                        'body' => $this->body
                    ]);
    }
}
