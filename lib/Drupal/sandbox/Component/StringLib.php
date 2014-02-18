<?php

/**
 * @file
 * Contains the StringLib class.
 */

namespace Drupal\sandbox\Component;

abstract class StringLib
{
  // -------------------------------------------------------------------------------------------------------------------------------------
  // VERTALERS
  // -------------------------------------------------------------------------------------------------------------------------------------

  /**
  * strtonormal()
  * Vertaalt speciale tekens naar gewone tekens
  * @param string $p_sString
  * @static
  * @access public
  * @return string
  */
  public static function strtonormal($p_sString)
  {
    $aSpecialChars = array("/[À-Å]/","/Æ/","/Ç/","/[È-Ë]/","/[Ì-Ï]/","/Ð/","/Ñ/","/[Ò-ÖØ]/","/×/","/[Ù-Ü]/","/[Ý-ß]/","/[à-å]/","/æ/","/ç/","/[è-ë]/","/[ì-ï]/","/ð/","/ñ/","/[ò-öø]/","/÷/","/[ù-ü]/","/[ý-ÿ]/");
    $aNormalChars = array("A","AE","C","E","I","D","N","O","X","U","Y","a","ae","c","e","i","d","n","o","x","u","y");
    return preg_replace($aSpecialChars, $aNormalChars, $p_sString);
  }

  /**
  * stripSpecialChars()
  * Vertaalt speciale tekens en gooit het meeste van de rest weg
  * @static
  * @access public
  * @return string
  */
  public static function stripSpecialChars( $p_sString )
  {
    $p_sString = self::strtonormal( $p_sString );

    $aSpecialChars = array("/[\"\'\.\,\/\;\:]/");
    $aNormalChars = array("");
    return preg_replace($aSpecialChars,$aNormalChars, $p_sString);
  }

  /**
  * getRegexSpecialChars()
  * Maakt van een string een regex die kan worden gebruikt om naar tekst te zoeken
  * waarbij speciale tekens in de tekst voor normale tekens aangezien moeten worden.
  * Bijvoorbeeld het woord 'ruïne' moet ook worden gevonden als de zoekterm 'ruine' is.
  * @param string $p_sString
  * @static
  * @access public
  * @return regex
  */
  public static function getRegexSpecialChars( $p_sString )
  {
    $aRegex_correctie = array (
      'a'   => '[aà-å]',
      'c'    => '[cç]',
      'd'    => '[dð]',
      'e'    => '[eè-ë]',
      'i'    => '[iì-ï]',
      'n'    => '[nñ]',
      'o'    => '[oò-öø]',
      'x'    => '[÷]',
      'u'    => '[uù-ü]',
      'y'    => '[yý-ÿ]',
      'A'    => '[AÀ-Å]',
      'C'    => '[CÇ]',
      'D'    => '[DÐ]',
      'E'    => '[EÈ-Ë]',
      'I'    => '[IÌ-Ï]',
      'N'    => '[NÑ]',
      'O'    => '[OÒ-ÖØ]',
      'X'    => '[X×]',
      'U'    => '[UÙ-Ü]',
      'Y'    => '[YÝ¥]',
    );
    return strtr($p_sString, $aRegex_correctie);
  }

  /**
  * makeAlias()
  * Genereert een 'alias', dwz deze functie vertaalt een tekenreeks naar een geschikte tekenreeks voor een url
  * @param string $p_sString : input string
  * @param int $p_iLength : maximum lengte van de string
  * @static
  * @access public
  * @return void
  */
  public static function makeAlias($p_sString, $p_iLength=60)
  {
    // Naar onderkast
    $p_sString = strtolower($p_sString);

    // Alle speciale tekens vertalen
    $p_sString = self::stripSpecialChars($p_sString);

    // Spaties en underscores vervangen door afbreekstreepjes
    $aSearch = array("/[\ \_]/");
    $aReplace = array("-");
    $p_sString = preg_replace($aSearch,$aReplace, $p_sString);

    // Tekenreeks afbreken
    if (strlen($p_sString) > $p_iLength)
    {
      $p_sString = substr($p_sString, 0, $p_iLength);
    }

    // Als laaste karakter een afbreekstreepje is, deze weghalen
    if (substr($p_sString, strlen($p_sString) -1, 1) == "-")
    {
      $p_sString = substr($p_sString, 0, strlen($p_sString) -1);
    }

    return $p_sString;
  }

  // -------------------------------------------------------------------------------------------------------------------------------------
  // GENERATORS
  // -------------------------------------------------------------------------------------------------------------------------------------

  /**
  * genereerCode()
  * Genereert willekeurige tekenreeks (standaard 8 tekens lang)
  * @param int $p_iAantaltekens: het aantal tekens dat de tekenreeks lang moet zijn.
  * @param $p_sRegex: regex waaraan elk teken moet voldoen
  * @static
  * @access public
  * @return string $sCode: de gegenereerde code
  */
  public static function genereerCode( $p_iAantaltekens=8, $p_sRegex='^[a-zA-Z0-9]$' )
  {
    $sCode = mt_srand((double)microtime()*100000);
    while(strlen($sCode) <= $p_iAantaltekens)
    {
      $i = chr(mt_rand (0,255));
      if (preg_match("/" . $p_sRegex . "/", $i))
      {
        $sCode .= $i;
      }
    }
    return $sCode;
  }

  /**
   * Genereert willekeurige tekenreeks (standaard 8 tekens lang) bedoeld voor wachtwoorden.
   *
   * @author http://www.anyexample.com/programming/php/php__password_generation.xml
   * @param int $p_iLength
   *   (optioneel) Het aantal tekens dat de tekenreeks lang moet zijn.
   *   Standaard: 8.
   * @param int $p_iStrength
   *   (optioneel) Hoe sterk het wachtwoord moet zijn.
   *   Standaard: 0.
   * @param array $p_aOptions
   *   (optioneel) Opties:
   *   - use_prefix (boolean)
   *     Of het wachtwoord vooraf moet gaan met een prefix.
   *     Standaard: FALSE.
   *   - use_suffix (boolean)
   *     Of aan het wachtwoord achteraf nog een suffix mag komen.
   *     Standaard: TRUE.
   *   - prefix (array)
   *     Lijst met te gebruiken prefixes.
   *   - suffix (array)
   *     Lijst met te gebruiken suffixes.
   *
   * @static
   * @access public
   * @return string
   *   Het gegenereerde wachtwoord.
   * @todo Genereert soms te veel karakters, waardoor er later karakters verwijderd moeten worden.
   * @todo Houdt (nog) geen rekening met suffixes die met een klinker beginnen.
   */
  public static function genereerWachtwoordNew($p_iLength = 8, $p_iStrength = 0, $p_aOptions = array()) {
    // Backwards compatibilty.
    if (!is_array($p_aOptions)) {
      $p_aOptions = array();
    }

    // Set default options.
    $p_aOptions += array(
      'use_prefix' => FALSE,
      'use_suffix' => TRUE,
      'prefix' => array(
        'aero', 'anti', 'auto', 'bi', 'bio',
        'cine', 'deca', 'demo', 'dyna', 'eco',
        'ergo', 'geo', 'gyno', 'hypo', 'kilo',
        'mega', 'tera', 'mini', 'nano', 'duo',
      ),
      'suffix' => array(
        'dom', 'ity', 'ment', 'sion', 'ness',
        'ence', 'er', 'ist', 'tion', 'or',
      ),
    );

    // 8 vowel sounds.
    $aVowels = array(
      'a', 'o', 'e', 'i', 'y', 'u', 'ou', 'oo',
    );
    // Chars that may be doubled.
    $aDoubles = array('n', 'm', 't', 's', 'N', 'M', 'T', 'S');
    // 20 consonants.
    $aSets['consonants'] = array(
      'w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j',
      'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'qu',
    );
    if ($p_iStrength >= 1) {
      // Upper consonants.
      $aSets['upper'] = array_map('strtoupper', $aSets['consonants']);
    }
    if ($p_iStrength >= 3) {
      // Digits.
      $aSets['digits'] = range(2, 9);
    }
    if ($p_iStrength >= 4) {
      // Special chars.
      $aSets['special'] = array(
        '!', '@', '#', '$', '%', '*', '?',
      );
    }

    // All sets.
    $aAll = array();
    foreach ($aSets as $aSet) {
      $aAll = array_merge($aAll, $aSet);
    }

    // Pick prefix and suffix.
    $sPasswordPrefix = ($p_aOptions['use_prefix']) ? self::getRandomArrayElement($p_aOptions['prefix']) : '';
    $sPasswordSuffix = ($p_aOptions['use_suffix']) ? self::getRandomArrayElement($p_aOptions['suffix']) : '';

    // Pick one from each set.
    // There must be at least one of each set in the password.
    $aPassConsonants = array();
    $aPassVowels = array();
    foreach ($aSets as $aSet) {
      $aPassConsonants[] = self::getRandomArrayElement($aSet);
      $aPassVowels[] = self::getRandomArrayElement($aVowels);
    }
    // Remove the last vowel from the array.
    array_pop($aPassVowels);
    $sRequired = implode('', $aPassConsonants) . implode('', $aPassVowels);

    // Calculate number of chars left to generate:
    // Chosen length - prefix length - suffix length - number of non-vowels - number of vowels.
    $iLeftOver = $p_iLength - strlen($sPasswordPrefix) - strlen($sPasswordSuffix) - strlen($sRequired);

    // Generate leftover chars.
    for ($i = 0; $i < $iLeftOver;) {
      // Generate a character from the sets.
      $sChar = self::getRandomArrayElement($aAll);
      // Maybe double it.
      if (in_array($sChar, $aDoubles) && ($i != 0)) {
        // 33% probability.
        if (rand(0, 2) == 1) {
          $sChar .= $sChar;
        }
      }
      $aPassConsonants[] = $sChar;
      $i += strlen($sChar);

      if ($i >= $iLeftOver) {
        break;
      }

      // Select a random vowel.
      $sVowel = self::getRandomArrayElement($aVowels);
      $aPassVowels[] = $sVowel;
      $i += strlen($sVowel);

      // @todo Werkt nog niet helemaal.
      if ($i >= $iLeftOver - 1) {
        // If suffix begins with vowel.
        if (in_array($sPasswordSuffix[0], $aVowels)) {
          // Add one more consonant.
          $aPassConsonants[] = self::getRandomArrayElement($aSets['consonants']);
        }
      }
    }

    // Shuffle consonants and vowels array.
    shuffle($aPassConsonants);
    shuffle($aVowels);

    // Now, finally build the password.
    // First, pick a consonant, follow it by a vowel, then another consonant
    // and so on until the length of the password is reached.
    $sPassword = '';
    while (count($aPassConsonants) || count($aPassVowels)) {
      if (count($aPassConsonants) > 0) {
        $sPassword .= array_shift($aPassConsonants);
      }
      if (count($aPassVowels) > 0) {
        $sPassword .= array_shift($aPassVowels);
      }
    }

    // Remove too much added characters.
    $iLength = $p_iLength - strlen($sPasswordPrefix) - strlen($sPasswordSuffix);
    if (strlen($sPassword) > $iLength) {
      $sPassword = substr($sPassword, 0, $iLength);
    }

    // Create complete password.
    $sPassword = $sPasswordPrefix . $sPassword . $sPasswordSuffix;

    return $sPassword;
  }

  /**
  * genereerWachtwoord()
  * Genereert willekeurige tekenreeks (standaard 8 tekens lang) bedoeld voor wachtwoorden
  * @author http://www.anyexample.com/programming/php/php__password_generation.xml
  * @param int $p_iLength: het aantal tekens dat de tekenreeks lang moet zijn.
  * @param int $p_iStrength: hoe moeilijk het wachtwoord moet zijn.
  * @static
  * @access public
  * @return string $sPassword: het gegenereerde wachtwoord
  */
  public static function genereerWachtwoord($p_iLength = 8, $p_iStrength = 0, $p_bUsePrefix = false)
  {
    // ------------------------------------
    // TEKSTDELEN SAMENSTELLEN
    // ------------------------------------
    // 20 prefixes.
    $aPrefix = array('aero', 'anti', 'auto', 'bi', 'bio',
      'cine', 'deca', 'demo', 'dyna', 'eco',
      'ergo', 'geo', 'gyno', 'hypo', 'kilo',
      'mega', 'tera', 'mini', 'nano', 'duo'
    );

    // 10 random suffixes.
    $aSuffix = array('dom', 'ity', 'ment', 'sion', 'ness',
      'ence', 'er', 'ist', 'tion', 'or'
    );

    // 8 vowel sounds.
    $aVowels = array('a', 'o', 'e', 'i', 'y', 'u', 'ou', 'oo');

    // 20 random consonants.
    $aConsonants = array('w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j',
      'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'qu'
    );
    $aDoubles = array('n', 'm', 't', 's', 'N', 'M', 'T', 'S');

    if ($p_iStrength >= 1)
    {
      $aUpperConsonants = $aConsonants;
      foreach ($aUpperConsonants as $iKey => $sValue)
      {
        $aUpperConsonants[$iKey] = strtoupper($sValue);
      }
      $aConsonants = array_merge($aConsonants, $aUpperConsonants);
    }
    if ($p_iStrength >= 2)
    {
      $aUpperVowels = $aVowels;
      foreach ($aUpperVowels as $iKey => $sValue)
      {
        $aUpperVowels[$iKey] = strtoupper($sValue);
      }
      $aVowels = array_merge($aVowels, $aUpperVowels);
    }
    if ($p_iStrength >= 3)
    {
      $aNumbers = range(2, 9);
      $aConsonants = array_merge($aConsonants, $aNumbers);
    }
    if ($p_iStrength >= 4)
    {
      $aSpecialChars = array('@','#','$','%');
      $aConsonants = array_merge($aConsonants, $aSpecialChars);
    }
    // ------------------------------------

    // ------------------------------------
    // WACHTWOORD GENEREREN
    // ------------------------------------
    $sPasswordPrefix = ($p_bUsePrefix) ? self::getRandomArrayElement($aPrefix) : '';
    $sPasswordSuffix = self::getRandomArrayElement($aSuffix);
    $sPassword = '';

    $iLengthPasswordNow = strlen($sPasswordPrefix) + strlen($sPasswordSuffix);
    $iLength = $p_iLength - $iLengthPasswordNow;

    for ($i = 0; $i < $iLength;)
    {
      // Selecting random consonant.
      $sConsonant = self::getRandomArrayElement($aConsonants);
      $sChar = $sConsonant;
      // Maybe double it.
      if (in_array($sChar, $aDoubles) && ($i != 0))
      {
        // 33% probability.
        if (rand(0, 2) == 1)
        {
          $sChar .= $sChar;
          $i++;
        }
      }
      $sPassword .= $sChar;
      $i += strlen($sConsonant);

      // Selecting random vowel.
      $sVowel = self::getRandomArrayElement($aVowels);
      $sPassword .= $sVowel;
      $i += strlen($sVowel);

      if ($i >= $iLength - 1)
      {
        // If suffix begin with vowel.
        if (in_array($sPasswordSuffix[0], $aVowels))
        {
          // Add one more consonant.
          $sPassword .= self::getRandomArrayElement($aConsonants);
        }
      }
    }

    // Remove to much added characters.
    if (strlen($sPassword) > $iLength)
    {
      $sPassword = substr($sPassword, 0, $iLength);
    }

    // Create complete password.
    $sPassword = $sPasswordPrefix . $sPassword . $sPasswordSuffix;

    return $sPassword;
  }

  /**
   * Returns a single entry of the input array.
   *
   * @param array $p_aArray
   *   The array to return an element from.
   *
   * @return mixed
   *   A random element of the array.
   */
  public static function getRandomArrayElement($p_aArray)
  {
    return $p_aArray[rand(0, sizeof($p_aArray)-1)];
  }

  // -------------------------------------------------------------------------------------------------------------------------------------
  // FIXERS
  // -------------------------------------------------------------------------------------------------------------------------------------

  /**
  * fixURL()
  * Voegt eventueel http:// toe voor de url (in opbouw)
  * @param string $p_sURL
  * @static
  * @access public
  * @return string
  */
  public static function fixURL( $p_sURL )
  {
    $sPattern1 = "^(https?://)";
    // Regex (deel) van http://www.osix.net/modules/article/?id=586
    $sPattern2 = "/^"
    //. "(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //user@
    . "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP- 199.194.52.184
    . "|" // allows either IP or domain
    . "([0-9a-z_!~*'()-]+\.)*" // tertiary domain(s)- www.
    . "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // second level domain
     // dont match (x)htm(l)(x), css, js, php, asp(x) pl, cgi, jp(e)g, gif, png, bmp, pdf, xls, doc(x), ppt, pps, txt
    . "(?!x?html?x?)(?!css?)(?!js?)(?!phps?)(?!aspx?)(?!pl)(?!cgi)(?!jpe?g)(?!gif)(?!png)(?!bmp)(?!pdf)(?!xls)(?!docx?)(?!ppt)(?!pps)(?!txt)"
    . "[a-z]{2,6})" // first level domain- .com or .museum
    . "(:[0-9]{1,4})?/" // port number- :80
    //. "((/?)|" // a slash isn't required if there is no file name
    //. "(/[0-9a-zA-Z_!~*'().;?:@&=+$,%#-]+)+/?)$"
    ;
    if (!ereg($sPattern1, $p_sURL) && preg_match($sPattern2, $p_sURL))
    {
      $p_sURL = 'http://' . $p_sURL;
    }
    return $p_sURL;
  }
}
