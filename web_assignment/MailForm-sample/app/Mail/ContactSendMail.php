<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $input;

    public function __construct(array $input)
    {
        $this->input = $input;
    }

    public function build()
    {
        return $this->subject('【お問い合わせ】受信通知')
            ->view('emails.contact')   // HTMLメール
            ->text('emails.contact_plain') // プレーンテキスト
            ->with(['input' => $this->input]);
    }
}
