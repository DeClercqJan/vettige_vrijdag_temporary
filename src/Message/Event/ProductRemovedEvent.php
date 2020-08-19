<?php

namespace App\Message\Event;

class ProductRemovedEvent implements NotifyAdminInterface
{
    public function getType(): string
    {
        return 'success';
    }

    public function getMessage(): string
    {
        return 'Het product werd verwijderd';
    }
}
