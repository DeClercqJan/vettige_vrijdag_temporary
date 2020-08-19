<?php

namespace App\Message\Event;

class LoggedInEvent implements NotifyAdminInterface
{
    public function getType(): string
    {
        return 'success';
    }

    public function getMessage(): string
    {
        return 'Je bent ingelogd';
    }
}
