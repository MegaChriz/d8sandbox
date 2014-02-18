<?php

/**
 * @file
 * Contains \Drupal\sandbox\Controller\sandboxController.
 */

namespace Drupal\sandbox\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\sandbox\Unit\UnitManager;
use Drupal\Component\Plugin\DefaultPluginBag;

/**
 * Controller routines for contact routes.
 */
class SandboxController extends ControllerBase implements ContainerInjectionInterface {
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
    if (empty($_GET['test'])) {
      $items = array(
        'calculator',
        'entity',
        'unit',
      );
      return 'put in ?test=entity';
    }

    switch ($_GET['test']) {
      case 'calculator':
        return $this->calculator();
      case 'entity':
        return $this->entity();
      case 'unit':
        return $this->unit();
    }
    return '404';
  }

  /**
   * Play with Calculator plugin.
   */
  protected function calculator() {
    $output = array();
    $manager = \Drupal::service('plugin.manager.calculator');
    $defs = $manager->getDefinitions();
    $settings = array(
      array(
        'id' => 'sandbox_plus',
      ),
      array(
        'id' => 'sandbox_multiply',
      ),
      array(
        'id' => 'sandbox_multiply',
      ),
      array(
        'id' => 'sandbox_plus',
      ),
      array(
        'id' => 'sandbox_multiply',
      ),
      array(
        'id' => 'sandbox_plus',
      ),
    );
    $bag = new DefaultPluginBag($manager, $settings);

    $number1 = 3012801;
    $number2 = 14497;
    foreach ($bag as $calc) {
      $number1 = $calc->calculate($number1, $number2);
    }
    $output[] = array(
      '#type' => 'item',
      '#title' => 'Calc 1 result',
      '#markup' => $number1,
    );

    $settings = array(
      array(
        'id' => 'sandbox_plus',
      ),
      array(
        'id' => 'sandbox_combine',
      ),
      array(
        'id' => 'sandbox_combine',
      ),
      array(
        'id' => 'sandbox_multiply',
      ),
    );
    $bag = new DefaultPluginBag($manager, $settings);

    $number1 = 10;
    $number2 = 2.20371;
    foreach ($bag as $calc) {
      $number1 = $calc->calculate($number1, $number2);
    }
    $output[] = array(
      '#type' => 'item',
      '#title' => 'Calc 2 result',
      '#markup' => $number1,
    );

    return $output;
  }

  /**
   * Play with config entities.
   */
  protected function entity() {
    $query = \Drupal::entityQuery('sand');
    $query->condition('color', '#00', 'STARTS_WITH');
    $result = $query->execute();
    $entities = entity_load_multiple('sand', $result);

    foreach ($entities as $entity) {
      //$output .= $entity->view();
    }

    $output = entity_view_multiple($entities, 'default');

    return $output;
  }

  /**
   * Play with units.
   */
  protected function unit() {
    $manager = new UnitManager();
    return 'unit';
  }
}