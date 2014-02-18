<?php

/**
 * @file
 * Contains \Drupal\sandbox\Annotation\Calculator.
 */

namespace Drupal\sandbox\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an calculator annotation object.
 *
 * @see hook_calculator_info_alter()
 *
 * @Annotation
 */
class Calculator extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the calculation.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

  /**
   * A brief description of the calculation.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation (optional)
   */
  public $description = '';

}
