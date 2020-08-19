<?php

namespace App\Message\Event;

class ProductUpdatedEvent implements NotifyAdminInterface
{
    public function getType(): string
    {
        return 'success';
    }

    public function getMessage(): string
    {
        return 'Het product werd geüpdatet';
    }
}
