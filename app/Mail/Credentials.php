<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Credentials extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $password;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$password,$name)
    {
        $this->email=$email;
        $this->password=$password;
        $this->name=$name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.credentials')->from('cmms.feather@gmail.com','CMMS TEAM')
            ->subject('Your Credentials');
    }
}
