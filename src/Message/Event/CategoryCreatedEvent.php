<?php

namespace App\Message\Event;

class CategoryCreatedEvent implements NotifyAdminInterface
{
    public function getType(): string
    {
        return 'success';
    }

    public function getMessage(): string
    {
        return 'Een nieuwe categorie werd aangemaak';
    }
}
