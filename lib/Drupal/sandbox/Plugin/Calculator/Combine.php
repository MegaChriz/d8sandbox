<?php

/**
 * @file
 * Contains \Drupal\sandbox\Plugin\Calculator\Combine.
 */

namespace Drupal\sandbox\Plugin\Calculator;

use Drupal\sandbox\CalculatorBase;

/**
 * Provide a plus calculation.
 *
 * @Calculator(
 *   id = "sandbox_combine",
 *   label = @Translation("Combine values"),
 *   description = @Translation("Combines values instead of doing a calculation.")
 * )
 */
class Combine extends CalculatorBase {
  /**
   * {@inheritdoc}
   */
  public function calculate($number1, $number2) {
    return (float) $number1 . $number2;
  }
}
