<?php

/**
 * @file
 * Contains the OutputLog class.
 */

namespace Drupal\sandbox\Component;

use Drupal\sandbox\Component\Debug;

/**
 * OutputLog class
 * Outputs debug arrays to a file when the object is destructed.
 *
 * USAGE
 * OutputLog::log($data);
 */
class OutputLog {
  /**
   * The data to log.
   *
   * @var array
   * @access protected
   */
  protected $data;

  /**
   * The file to output to.
   *
   * @var string
   * @access protected
   */
  protected $filename;

  /**
   * OutputLog object constructor
   *
   * @access private
   * @return void
   */
  private function __construct() {
    $this->data = array();
    $this->filename = 'output';
  }

  /**
   * Desctructor
   *
   * @access public
   * @return void
   */
  public function __destruct() {
    $this->save();
  }

  /**
   * Saves data to file.
   *
   * @param string $filename
   *   (optional) The file to save the data to.
   *   Defaults to filename property already set.
   * @param string $dir
   *   (optional) The directory to save the file to.
   *   Defaults to '/tmp'.
   * @param string $function
   *   The function to use when formatting the data.
   *   Defaults to 'print_r_tree'.
   *
   * @access public
   * @return OutputLog
   *   Returns current instance.
   */
  public function save($filename = '', $dir = NULL, $function = 'print_r_tree') {
    if (empty($filename)) {
      $filename = $this->filename;
    }
    if (empty($dir)) {
      $dir = '/tmp';
    }
    file_put_contents($dir . '/' . $filename . '.html', $this->formatData($function));
    return $this;
  }

  /**
   * Returns instance.
   *
   * @access public
   * @static
   * @return OutputLog
   *   Returns current instance.
   */
  public static function getInstance() {
    static $oLog = NULL;
    if (!is_object($oLog)) {
      $oLog = new self();
    }
    return $oLog;
  }

  /**
   * Log something.
   *
   * @param mixed $data
   *
   * @access public
   * @static
   * @return OutputLog
   *   Returns current instance.
   */
  public static function log($data) {
    $oLog = self::getInstance();
    $oLog->data[] = $data;
    return $oLog;
  }

  /**
   * Set filename.
   *
   * @param string $filename
   *
   * @access public
   * @static
   * @return OutputLog
   *   Returns current instance.
   */
  public static function setFilename($filename) {
    $oLog = self::getInstance();
    $oLog->filename = (string) $filename;
    return $oLog;
  }

  /**
   * Format data before saving it to a file.
   *
   * @param string $function
   *   The function to use when formatting the data.
   *   Defaults to 'print_r_tree'.
   *
   * @return string
   *   The data to write to the file.
   */
  protected function formatData($function = 'print_r_tree') {
    if (!function_exists($function)) {
      // Fallback to print_r_tree() when function does not exists.
      $function = 'print_r_tree';
    }
    switch ($function) {
      case 'print_r':
        return $function($this->data, TRUE);
      default:
        return Debug::$function($this->data, '$data', TRUE);
    }
  }
}
