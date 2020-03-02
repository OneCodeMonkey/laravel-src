<?php

namespace Illuminate\Mail\Events;

class MessageSending
{
    /**
     * The Swift message instance.
     *
     * @var \Swift_Message
     */
    public $message;

    /**
     * The message data.
     *
     * @var array
     */
    public $data;

    public function __construct($message, $data = [])
    {
        $this->message = $message;
        $this->data = $data;
    }
}
