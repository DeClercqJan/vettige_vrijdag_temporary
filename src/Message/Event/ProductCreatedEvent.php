<?php

namespace App\Message\Event;

class ProductCreatedEvent implements NotifyAdminInterface
{
    public function getType(): string
    {
        return 'success';
    }

    public function getMessage(): string
    {
        return 'Een nieuw product werd aangemaakt';
    }
}
