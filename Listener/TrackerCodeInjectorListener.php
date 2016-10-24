<?php
/**
 * Copyright Piwik Team 2016
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

namespace Phaidon\PiwikModule\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * TrackerCodeInjectorListener injects the Piwik tracker code into the page output.
 *
 * The onKernelResponse method must be connected to the kernel.response event.
 */
class TrackerCodeInjectorListener implements EventSubscriberInterface
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        // TODO legacy calls
        if (\FormUtil::getPassedValue('type', 'user', 'GETPOST') == 'ajax') {
            return;
        }

        \ModUtil::apiFunc('PhaidonPiwikModule', 'user', 'tracker');
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -4],
        ];
    }
}
