<?php

/**
 * @file
 * Contains Drupal\sandbox\Unit\UnitManagerInterface.
 */

namespace Drupal\sandbox\Unit;

/**
 * Interface solely ment for unit testing.
 */
interface UnitManagerInterface extends \Countable, \Traversable {
  /**
   * Adds a single Unit.
   *
   * @param UnitInterface $unit
   *   The unit to add.
   */
  public function addUnit(UnitInterface $unit);
}
