<?php

/**
 * @file
 * Contains TryTest class.
 */

namespace Drupal\sandbox\Tests;

/**
 * A simple PHPUnit test class.
 *
 * @group sandbox
 */
class TryTest extends \PHPUnit_Framework_TestCase {
  /**
   * Just a sample test method.
   */
  public function testOne() {
    $this->assertEquals(1, 1);
    // Failing assert.
    $this->assertEquals(1, 2);
  }

  /**
   * Method with data provider.
   *
   * @dataProvider addDataProvider()
   *
   * @see TryTest::addDataProvider()
   */
  public function testWithDataProvider($expected, $a, $b) {
    $this->assertEquals($expected, $a + $b);
  }

  /**
   * Data provider for testWithDataProvider().
   *
   * Data provider methods take no arguments and return an array of data
   * to use for tests. Each element of the array is another array, which
   * corresponds to the arguments in the test method's signature.
   *
   * Note also that PHPUnit tries to run tests using methods that begin
   * with 'test'. This means that data provider method names should not
   * begin with 'test'. Also, by convention, they should end with
   * 'DataProvider'.
   *
   * @see AddClassTest::testWithDataProvider()
   */
  public function addDataProvider() {
    return array(
      // array($expected, $a, $b)
      array(5, 2, 3),
      array(50, 20, 30),
    );
  }
}
