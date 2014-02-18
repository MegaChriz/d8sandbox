<?php

/**
 * @file
 * Contains Drupal\sandbox\Unit\UnitInterface.
 */

namespace Drupal\sandbox\Unit;

/**
 * Interface solely ment for unit testing.
 */
interface UnitInterface {
  /**
   * Get ID of unit.
   *
   * @return scalar
   *   Return value must be an integer or a string.
   */
  public function getId();
}
