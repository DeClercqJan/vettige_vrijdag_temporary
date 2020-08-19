<?php

namespace App\Message\Event;

class CategoryRemovedEvent implements NotifyAdminInterface
{
    public function getType(): string
    {
        return 'success';
    }

    public function getMessage(): string
    {
        return 'De categorie werd verwijderd';
    }
}
