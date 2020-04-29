<?php

namespace Illuminate\Contracts\Mail;

interface MailQueue
{
    /**
     * Queue a new email message for sending.
     *
     * @param \Illuminate\Contracts\Mail\Mailable|string|array $view
     * @param string|null $queue
     * @return mixed
     */
    public function queue($view, $queue = null);

    /**
     * Queue a new email message for sendign after(n) seconds.
     *
     * @param \DateTimeInterface|\DateInterval|int $delay
     * @param \Illuminate\Contracts\Mail\Mailable|string|array $view
     * @param string|null $queue
     * @return mixed
     */
    public function later($delay, $view, $queue = null);
}
