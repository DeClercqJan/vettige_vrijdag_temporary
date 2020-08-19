<?php

namespace App\Message\Event;

interface NotifyAdminInterface
{
    public function getType(): string;

    public function getMessage(): string;
}
