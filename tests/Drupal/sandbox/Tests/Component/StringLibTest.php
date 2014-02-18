<?php

/**
 * @file
 * Contains Drupal\phpunit_example\Tests\DisplayManagerTest
 */

namespace Drupal\sandbox\Tests\Component;

use Drupal\Tests\UnitTestCase;
use Drupal\sandbox\Component\OutputLog;
use Drupal\sandbox\Component\StringLib;

/**
 * A PHPUnit example test case against an example class.
 *
 * @todo: More documentation.
 *
 * @ingroup sandbox
 * @group sandboxlib
 */
class StringLibTest extends UnitTestCase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Sandbox StringLib Unit Test',
      'description' => '.',
      'group' => 'Sandbox',
    );
  }

  /**
   * Test password generator.
   *
   * @dataProvider generatePasswordProvider
   */
  public function XtestGeneratePassword($regex, $length = 8, $strength = 0, $options = array()) {
    return;
    $password = StringLib::genereerWachtwoordNew($length, $strength, $options);
    $this->assertRegExp($regex, $password);
  }

  /**
   * Data provider for testGeneratePassword().
   *
   * @see StringLibTest::testGeneratePassword()
   */
  public function generatePasswordProvider() {
    $options = array(
      'use_suffix' => FALSE,
    );
    $tests = array(
      // Test password length.
      array('/[a-z]{8}/', 8),
      array('/[a-z]{20}/', 20),
      array('/[a-z]{6}/', 6),
      array('/[a-z]{1}/', 1),
      // Test password strength.
      array('/^[a-z]+$/', 8, 0),
      array('/^(?=.*[a-z])(?=.*[A-Z])([a-zA-Z]+)$/', 8, 1),
      array('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])([a-zA-Z0-9]+)$/', 8, 3),
      array('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\*\?])([a-zA-Z0-9!@#\$%\*\?]+)$/', 8, 4),
      // Test password length + strength and dismiss the suffix.
      array('/^[a-z]+$/', 1, 0, $options),
      array('/^(?=.*[a-z])(?=.*[A-Z])([a-zA-Z]+)$/', 2, 1, $options),
      array('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])([a-zA-Z0-9]+)$/', 3, 3, $options),
      array('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\*\?])([a-zA-Z0-9!@#\$%\*\?]+)$/', 4, 4, $options),
    );

    // Multiply by 100 to prevent random test failures.
    $return = array();
    for ($i = 0; $i < 200; $i++) {
      $return = array_merge($return, $tests);
    }
    //OutputLog::log($return);

    return $return;
    // '!', '@', '#', '$', '%', '*', '?',
  }
}
