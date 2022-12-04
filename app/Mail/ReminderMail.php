<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $address, $shop_name, $date, $time, $number)
    {
        $this->name = $name;
        $this->mail_address = $address;
        $this->shop_name = $shop_name;
        $this->date = $date;
        $this->time = $time;
        $this->number = $number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->mail_address)
                    ->subject('予約日時のご連絡')
                    ->view('mail_reminder')
                    ->with([
                        'name' => $this->name,
                        'shop_name' => $this->shop_name,
                        'date' => $this->date,
                        'time' => $this->time,
                        'number' => $this->number
                    ]);
    }
}
