<?php

namespace App\Application\Shared\Actions;

final class BuildShareLinksAction
{
    public function execute(): array
    {
        return \Share::currentPage()
            ->facebook()
            ->twitter()
            ->linkedin()
            ->reddit()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();
    }
}
