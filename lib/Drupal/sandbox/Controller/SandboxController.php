<?php

/**
 * @file
 * Contains \Drupal\sandbox\Controller\sandboxController.
 */

namespace Drupal\sandbox\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller routines for contact routes.
 */
class sandboxController extends ControllerBase implements ContainerInjectionInterface {
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static();
    /*
    return new static(
      $container->get('module_handler')
    );
    */
  }

  /**
   * Presents a sample page.
   */
  public function page() {
    $query = \Drupal::entityQuery('sand');
    $query->condition('color', '#00', 'STARTS_WITH');
    $result = $query->execute();
    $entities = entity_load_multiple('sand', $result);

    foreach ($entities as $entity) {
      //$output .= $entity->view();
    }

    $output = entity_view_multiple($entities, 'default');
    
    return 'hello';
  }
}