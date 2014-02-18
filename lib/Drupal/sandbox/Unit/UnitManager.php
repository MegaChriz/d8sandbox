<?php

/**
 * @file
 * Contains Drupal\sandbox\Unit\UnitManager.
 */

namespace Drupal\sandbox\Unit;

/**
 * Class solely ment for unit testing.
 */
class UnitManager implements \IteratorAggregate, UnitManagerInterface {
  /**
   * A list of units.
   *
   * @var array
   */
  protected $units;

  /**
   * Implements \IteratorAggregate::getIterator().
   */
  public function getIterator() {
    return new \ArrayIterator($this->units);
  }

  /**
   * Implements \Countable::count().
   */
  public function count() {
    return isset($this->units) ? count($this->units) : 0;
  }

  /**
   * Implements UnitManagerInterface::addUnit().
   */
  public function addUnit(UnitInterface $unit) {
    $id = $unit->getId();
    if (empty($id) || !is_scalar($id)) {
      throw new \InvalidArgumentException('The id of the Unit must be a scalar.');
    }
    $this->units[$id] = $unit;
  }

  /**
   * Returns all units.
   *
   * @return array
   *   The units.
   */
  public function getUnits() {
    return $this->units;
  }
}
