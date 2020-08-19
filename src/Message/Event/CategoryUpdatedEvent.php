<?php

namespace App\Message\Event;

class CategoryUpdatedEvent implements NotifyAdminInterface
{
    public function getType(): string
    {
        return 'success';
    }

    public function getMessage(): string
    {
        return 'De categorie werd geüpdatet';
    }
}
