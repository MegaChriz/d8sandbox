<?php

/**
 * @file
 * Contains \Drupal\sandbox\EventSubscriber\sandboxEventSubscriber.
 */

namespace Drupal\sandbox\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class sandboxEventSubscriber implements EventSubscriberInterface {
  /**
   * Does something.
   */
  public function onResponse(FilterResponseEvent $event) {
    return;
    $response = $event->getResponse();
    if ($response->getStatusCode() == 404) {
      $content = $response->getContent();
      $content = '<p>sandbox module: jammer, maar die pagina bestaat niet.</p>';
      $response->setContent($content);
      //print_r_tree($content);die();
    }
    elseif ($response->getStatusCode() == 403) {
      $content = $response->getContent();
      $content = '<p>sandbox module: jammer, maar dit is verboden terrein.</p>';
      $response->setContent($content);
      //print_r_tree($content);die();
    }
    else {
      //$response->setStatusCode(403);
    }
  }

  /**
   * Implements EventSubscriberInterface::getSubscribedEvents().
   *
   * @return array
   *   An array of event listener definitions.
   */
  static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('onResponse', -100);
    return $events;
  }
}

/*
Events classes:
  Symfony\Component\HttpKernel\KernelEvents
  Drupal\Core\Routing\RoutingEvents
Other:
  config.init
  config.importer.import
  config.importer.validate
  config.installer.validate
*/
