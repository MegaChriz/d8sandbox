<?php

/**
 * @file
 * Contains Drupal\phpunit_example\Tests\DisplayManagerTest
 */

namespace Drupal\sandbox\Tests\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\sandbox\Unit\UnitManager;
use Drupal\sandbox\Unit\UnitInterface;
use Drupal\sandbox\Component\OutputLog;

/**
 * A PHPUnit example test case against an example class.
 *
 * @todo: More documentation.
 *
 * @ingroup sandbox
 * @group sandbox
 */
class UnitManagerTest extends UnitTestCase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Sandbox UnitManager Unit Test',
      'description' => '.',
      'group' => 'Sandbox',
    );
  }

  /**
   * Test.
   */
  public function testSimpleMockUnitManager() {
    // Create mock.
    $mock = $this->getMock('Drupal\sandbox\Unit\UnitInterface');
    $this->assertTrue($mock instanceof UnitInterface);

    $id = uniqid();
    $mock->expects($this->any())
      ->method('getId')
      ->will($this->returnValue($id));

    // Create a new UnitManager, the class we test.
    $manager = new UnitManager();
    // Add a unit to the manager.
    $manager->addUnit($mock);
    // Assert that manager contains one unit.
    $this->assertEquals(1, $manager->count());
    // Assert that manager contains exactly our mock.
    $this->assertSame($mock, reset($manager->getIterator()));

    //$units = $manager->getUnits();
    //$units = current($manager->getIterator());
    //OutputLog::log($units);
  }
}
