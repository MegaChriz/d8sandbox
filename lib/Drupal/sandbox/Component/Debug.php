<?php

/**
 * @file
 * Contains the Debug class.
 */

namespace Drupal\sandbox\Component;

use Drupal\sandbox\Component\OutputLog;

abstract class Debug {
  // ---------------------------------------------------------------------------
  // PRINT
  // ---------------------------------------------------------------------------

  /**
  * print_p()
  * Print gegevens op scherm tussen <pre>-tags.
  * @param mixed $p_mVar
  * @param string $p_sName
  * @param boolean $p_bReturn
  * @return void
  */
  function print_p($p_mVar, $p_sName='', $p_bReturn=false)
  {
    $sOutput = "<pre>\n$p_sName"
    . print_r($p_mVar, true)
    . "</pre>\n<hr>\n"
    ;

    if ($p_bReturn == false)
    {
      echo $sOutput;
    }
    else
    {
      return $sOutput;
    }
  }

  /**
  * print_textarea()
  * Print gegevens op scherm tussen <textarea>-tags.
  * @param mixed $p_mVar
  * @param string $p_sName
  * @param boolean $p_bReturn
  * @return void / string
  */
  function print_textarea($p_mVar, $p_sName='', $p_bReturn=false)
  {
    $sOutput = $p_sName. '<br />'
    . "<textarea>\n"
    . print_r($p_mVar, true)
    . "</textarea>\n<hr>\n"
    ;

    if ($p_bReturn == false)
    {
      echo $sOutput;
    }
    else
    {
      return $sOutput;
    }
  }

  /**
  * print_r_tree
  * Print gegevens met uitklapmogelijkheden
  * @param mixed $p_mVar
  * @param string $p_sName
  * @param boolean $p_bReturn
  * @author Bob
  * @return void / string
  *
  * @see http://www.php.net/manual/en/function.print-r.php#90759
  */
  function print_r_tree($p_mVar, $p_sName='', $p_bReturn=false)
  {
    // capture the output of print_r
    $sOutput = print_r($p_mVar, true);

    // String div replace try
    $sJoker = 'a';
    if (strpos($sOutput, $sJoker) === false)
    {
      $sOutput = preg_replace('/(<\/div>[ \t\n]*\[)/i', $sJoker.'${1}', $sOutput);
      $sOutput = preg_replace('/([ \t]*)(\[[^\]]+\][ \t]*\=\>[ \t]*)<div([^'.$sJoker.']+)'.$sJoker.'<\/div>([ \t\n]*)\[/iUe', "'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\"><div\\3</div></div>\\4['", $sOutput);
      $sOutput = str_ireplace($sJoker, '', $sOutput);
      //$sOutput = preg_replace('/^\s*\<\/div>\s*$/m', '</div></div>', $sOutput);
    }

    // replace something like '[element] => <newline> (' with <a href="javascript:toggleDisplay('...');">...</a><div id="..." style="display: none;">
    //$sOutput = preg_replace('/([ \t]*)(\[[^\]]*\][ \t]*\=\>[ \t]*[a-z0-9 \t_]+)\n[ \t]*\(/iUe', "'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $sOutput);
    $sOutput = preg_replace('/([ \t]*)(\[.*\][ \t]*\=\>[ \t]*[a-z0-9 \t_]+)\n[ \t]*\(/iUe', "'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $sOutput);

    // replace ')' on its own on a new line (surrounded by whitespace is ok) with '</div>
    $sOutput = preg_replace('/^\s*\)\s*$/m', '</div>', $sOutput);

    // define the javascript function toggleDisplay() and then the transformed output
    $sOutput = '<script language="Javascript">function toggleDisplay(id) { document.getElementById(id).style.display = (document.getElementById(id).style.display == "block") ? "none" : "block"; }</script>'."\n$sOutput";

    $sOutput = "<pre>\n$p_sName"
    . $sOutput
    . "</pre>\n<hr>\n"
    ;

    if ($p_bReturn == false)
    {
      echo $sOutput;
    }
    else
    {
      return $sOutput;
    }
  }

  /**
  * var_p()
  * Print var_dump op scherm tussen <pre>-tags.
  * @param mixed $p_mVar
  * @return void
  */
  function var_p($p_mVar, $p_sName='')
  {
    echo "<pre>\n$p_sName";
    var_dump($p_mVar);
    echo "</pre>\n<hr>\n";
  }

  /**
  * var_textarea()
  * Print var_dump op scherm tussen <textarea>-tags.
  * @return void
  */
  function var_textarea($p_mVar, $p_sName='')
  {
    echo $p_sName. '<br />';
    echo "<textarea>\n";
    var_dump($p_mVar);
    echo "</textarea>\n<hr>\n";
  }

  /**
   * Print var_export() op scherm tussen <textarea>-tags.
   * @return void|string
   */
  function var_export_textarea($p_mVar, $p_sName='', $p_bReturn = FALSE) {
    $sOutput = $p_sName. '<br />';
    $sOutput .= "<textarea>\n";
    $sOutput .= @var_export($p_mVar, TRUE);
    $sOutput .= "</textarea>\n<hr>\n";

    if ($p_bReturn == false)
    {
      echo $sOutput;
    }
    else
    {
      return $sOutput;
    }
  }

  /**
   * var_dump_tree()
   * Print var_dump met uitklapmogelijkheden (poging)
   * @param mixed $p_mVar
   * @return void
  */
  function var_dump_tree($p_mVar, $p_sName='')
  {
    // capture the output of var_dump
    ob_start();
    var_dump($p_mVar);
    $sOutput = ob_get_contents();
    ob_end_clean();

    echo "<pre>\n$p_sName";
    // replace " with &quote;
    $sOutput = preg_replace('/\"/', '&quot;', $sOutput);

    // replace something like 'object(ConnectFourFactory)#3 (7) {' with <a href="javascript:toggleDisplay('...');">...</a><div id="..." style="display: none;">
    //$sOutput = preg_replace('/[ \t]*\n([ \t]*)([a-zA-Z][^\{\>]+)[ \t]*\{/iUe',"'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $sOutput);
    $sOutput = preg_replace('/([ \t]*)(\[[^\]]+\][ \t]*\=\>)[ \t]*\n([ \t]*)([a-zA-Z][^\{\>]+)[ \t]*\{/iUe',"'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2 \\4</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $sOutput);

    // replace '}' on its own on a new line (surrounded by whitespace is ok) with '</div>
    $sOutput = preg_replace('/^\s*\}\s*$/m', '</div>', $sOutput);

    // print the javascript function toggleDisplay() and then the transformed output
    echo '<script language="Javascript">function toggleDisplay(id) { document.getElementById(id).style.display = (document.getElementById(id).style.display == "block") ? "none" : "block"; }</script>'."\n$sOutput";
    echo "</pre>\n<hr>\n";
  }

  /**
  * print_keys()
  * Print van een array alleen de keys.
  * Te gebruiken voor zeer grote arrays.
  * @param array $p_aArray
  * @return void
  */
  function print_keys($p_aArray, $p_sName='')
  {
    if (!is_array($p_aArray) && count($p_aArray) < 1)
    {
      return;
    }
    echo $p_sName. '<br />';
    echo gettype($p_aArray). '<br />';
    echo '<ul>';
    foreach ($p_aArray as $sKey => $mValue)
    {
      $sType = gettype($mValue);
      switch ($sType)
      {
        case 'string':
          echo '<span style="color: rgb(221, 0, 0);">';
          break;
        case 'integer':
          echo '<span style="color: rgb(0, 0, 187);">';
          break;
        case 'boolean':
          echo '<span style="color: rgb(255, 128, 0);">';
          break;
        case 'NULL':
          echo '<span style="color: #770077;">';
          break;
        case 'array':
          echo '<span style="color: rgb(0, 119, 0);">';
          break;
        case 'object':
          echo '<span style="color: #CC00FF;">';
          break;

        default:
          echo '<span>';
          break;
      }

      echo "<li>$sKey <em>(".$sType.")</em></span></li>";
    }
    echo "</ul>\n<hr>\n";
  }

  /**
   * Iets schrijven naar /tmp/output.html
   *
   * @param mixed $p_mData
   *   De gegevens om te loggen.
   *   Dit mag ook een array of een object zijn.
   *
   * @return OutputLog
   *   An instance of OutputLog.
   */
  function outputlog($p_mData) {
    if (!class_exists('OutputLog')) {
      throw new \Exception('OutputLog class not found.');
    }
    // Find the caller.
    $_ = array_reverse(debug_backtrace());
    while ($d = array_pop($_)) {
      // DEVEL: changed if() condition below
      if (1) {
        break;
      }
    }
    if (@$d['file']) {
      $d2 = array_pop($_);
      $d['function'] = $d2['function'];
      $d3 = array();
      foreach ($d as $key => $value) {
        $d3['!' . $key] = $value;
      }
      OutputLog::log(date('Y-m-d H:i:s') . ' - ' . strtr('Called from function !function() in !file, line !line', $d3));
    }

    OutputLog::log($p_mData);
    return OutputLog::getInstance();
  }

  // ---------------------------------------------------------------------------
  // FILTER
  // ---------------------------------------------------------------------------

  /**
  * filter_keys
  * Houdt van een array alleen onderdelen over die voldoen aan regex
  * @param array $p_aArray
  * @param string $p_sRegex
  * @return array
  */
  function filter_keys($p_aArray, $p_sRegex)
  {
    $aReturn = array();
    foreach ($p_aArray as $sKey => $mValue)
    {
      if (preg_match($p_sRegex, $sKey))
      {
        $aReturn[$sKey] = $mValue;
      }
    }
    return $aReturn;
  }
}
