<?php

/**
 * @file
 * Contains \Drupal\sandbox\CalculatorInterface.
 */

namespace Drupal\sandbox;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Core\Image\ImageInterface;

/**
 * Defines the interface for calculations.
 */
interface CalculatorInterface extends PluginInspectionInterface, ConfigurablePluginInterface {

  /**
   * Performs a calculation.
   *
   * @param float $number1
   *   The first number.
   * @param integer $number2
   *   The second number.
   *
   * @return float
   *   The result of the calculation.
   */
  public function calculate($number1, $number2);
}
