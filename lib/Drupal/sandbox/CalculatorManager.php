<?php

/**
 * @file
 * Contains \Drupal\sandbox\CalculatorManager.
 */

namespace Drupal\sandbox;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages calculator plugins.
 */
class CalculatorManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Calculator', $namespaces, 'Drupal\sandbox\Annotation\Calculator');

    $this->alterInfo($module_handler, 'calculator_info');
    $this->setCacheBackend($cache_backend, $language_manager, 'calculator_plugins');
  }

}
