<?php

declare(strict_types=1);

namespace App\Listener;


use Symfony\Component\HttpKernel\Event\ResponseEvent;

class HireHackersListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $event->getResponse()->setContent(
            str_replace(
                '</body>',
                '<!-- If you can see this message, please contact us at jobs@smile.fr. --></body>',
                $event->getResponse()->getContent()
            )
        );
        $event->getResponse()->headers->add([
            'Join-Us' => 'If you can see this message, please contact us at jobs@smile.fr.'
        ]);
    }
}
