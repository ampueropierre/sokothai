<?php

namespace App\Controller\Api;

use App\Entity\Event;
use Symfony\Component\Security\Core\Security;

class EventCreatorController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(Event $data)
    {
        $data->setUser($this->security->getUser());

        return $data;
    }
}