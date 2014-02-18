<?php

/**
 * @file
 * Contains \Drupal\sandbox\Plugin\Calculator\Plus.
 */

namespace Drupal\sandbox\Plugin\Calculator;

use Drupal\sandbox\CalculatorBase;

/**
 * Provide a plus calculation.
 *
 * @Calculator(
 *   id = "sandbox_plus",
 *   label = @Translation("Sums values"),
 *   description = @Translation("Sums number 1 with number 2.")
 * )
 */
class Plus extends CalculatorBase {
  /**
   * {@inheritdoc}
   */
  public function calculate($number1, $number2) {
    return $number1 + $number2;
  }
}
