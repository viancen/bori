<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = $this->data['order']['email'];
        $subject = 'Nieuwe bestelling: ' . $this->data['dish']['name'];
        $name = $this->data['order']['full_name'];

        return $this->view('emails.default')
            ->from('bestellingen@bori.amsterdam', 'Bori')
            ->to($address, $name)
            ->bcc('bestellingen@bori.amsterdam', 'Bori Amsterdam')
            ->replyTo($address, $name)
            ->subject($subject)
            ->with(['msg' => $this->data['msg']]);
    }
}
