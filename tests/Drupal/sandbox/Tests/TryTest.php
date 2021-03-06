<?php

/**
 * @file
 * Contains TryTest class.
 *
 * To execute this test on command line:
 * cd core
 * ./vendor/bin/phpunit --group sandbox
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
    //$this->assertEquals(1, 2);
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

  /**
   * This is an example of expecting a PHP warning.
   *
   * @expectedException PHPUnit_Framework_Error_Warning
   */
  public function testWarning() {
    include 'file.php';
  }

  /**
   * This is an example of expecting a PHP notice.
   *
   * @expectedException PHPUnit_Framework_Error_Notice
   */
  public function testNotice() {
    $test .= 'test';
  }

  /**
   * According to the PHPUnit documentation, testing that the generic
   * Exception is expected is "not permitted", though on 3.7.21 it
   * still passes.
   *
   * @expectedException Exception
   */
  public function testGenericException() {
    throw new \Exception();
  }
}
