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

use Phaidon\PiwikModule\Helper\UserOutputHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * TrackerCodeInjectorListener injects the Piwik tracker code into the page output.
 *
 * The onKernelResponse method must be connected to the kernel.response event.
 */
class TrackerCodeInjectorListener implements EventSubscriberInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var UserOutputHelper
     */
    private $userOutputHelper;

    /**
     * Constructor.
     *
     * @param KernelInterface  $kernel           KernelInterface service instance
     * @param UserOutputHelper $userOutputHelper UserOutputHelper service instance
     */
    public function __construct(KernelInterface $kernel, UserOutputHelper $userOutputHelper) {
        $this->kernel = $kernel;
        $this->userOutputHelper = $userOutputHelper;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (null === $this->kernel->getModule('PhaidonPiwikModule')) {
            return;
        }

        $response = $event->getResponse();
        $request = $event->getRequest();

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $this->userOutputHelper->tracker();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -4],
        ];
    }
}
