<?php
/**
 * @author      Ni Irrty <niirrty+code@gmail.com>
 * @copyright   ©2017, Niirrty
 * @package     Niirrty\Locale
 * @since       2017-10-31
 * @version     0.1.0
 */


declare( strict_types = 1 );


namespace Niirrty\Locale;


/**
 * A Class with some static helper methods for Locale handling.
 *
 * @since v0.1.0
 */
abstract class LocaleHelper
{


   // <editor-fold desc="// – – –   P U B L I C   S T A T I C   F I E L D S   – – – – – – – – – – – – – – – – – –">

   # <editor-fold desc=" - $WindowsLocales - ">
   /**
    * With this array you are able to convert a windows typical locale definition like
    * <code style="color: blue">German_Germany</code> to a LCID like <code style="color: blue">de_DE</code>
    *
    * But do not use it directly (you can do it at your own risk). Use the Method ConvertWinToLCID(...)
    *
    * @var    array
    */
   public static $WindowsLocales = [
      // Locale Language  => LCID
      'afrikaans' => 'af',  'albanian' => 'sq', 'amharic' => 'am', 'arabic_algeria' => 'ar_DZ',
      'arabic_bahrain' => 'ar_BH', 'arabic_egypt' => 'ar_EG', 'arabic_iraq' => 'ar_IQ',
      'arabic_jordan' => 'ar_JO', 'arabic_kuwait' => 'ar_KW', 'arabic_lebanon' => 'ar_LB',
      'arabic_libya' => 'ar_LY', 'arabic_morocco' => 'ar_MA', 'arabic_oman' => 'ar_OM', 'arabic_qatar' => 'ar_QA',
      'arabic_saudi_arabia' => 'ar_SA', 'arabic_saudiarabia' => 'ar_SA', 'arabic_syria' => 'ar_SY',
      'arabic_tunisia' => 'ar_TN', 'arabic_united_arab_emirates' => 'ar_AE', 'arabic_yemen' => 'ar_YE',
      'armenian' => 'hy', 'assamese' => 'as', 'azeri_cyrillic' => 'az_AZ', 'azeri_latin' => 'az_AZ',
      'basque' => 'eu', 'belarusian' => 'be', 'bengali_bangladesh' => 'bn', 'bengali_india' => 'bn',
      'bosnian' => 'bs', 'bulgarian' => 'bg', 'burmese' => 'my', 'catala' => 'ca', 'chinese_china' => 'zh_CN',
      'chinese_hong_kong' => 'zh_HK', 'chinese_hongkong' => 'zh_HK', 'chinese_macau_sar' => 'zh_MO',
      'chinese_macau' => 'zh_MO', 'chinese_singapore' => 'zh_SG', 'chinese_taiwan' => 'zh_TW',
      'croatian' => 'hr', 'czech' => 'cs', 'danish' => 'da', 'dutch_belgium' => 'nl_BE',
      'dutch_netherlands' => 'nl_NL', 'english_australia' => 'en_AU', 'english_belize' => 'en_BZ',
      'english_canada' => 'en_CA', 'english_caribbean' => 'en_CB', 'english_great_britain' => 'en_GB',
      'english_india' => 'en_IN', 'english_ireland' => 'en_IE', 'english_jamaica' => 'en_JM',
      'english_new_zealand' => 'en_NZ', 'english_phillippines' => 'en_PH', 'english_southern_africa' => 'en_ZA',
      'english_trinidad' => 'en_TT', 'english_united_states' => 'en_US', 'english_zimbabwe' => 'en',
      'estonian' => 'et', 'fyro_macedonia' => 'mk', 'faroese' => 'fo', 'farsi_persian' => 'fa',
      'finnish' => 'fi', 'french_belgium' => 'fr_BE', 'french_cameroon' => 'fr', 'french_canada' => 'fr_CA',
      'french_congo' => 'fr', 'french_cote_d_ivoire' => 'fr', 'french_france' => 'fr_FR',
      'french_luxembourg' => 'fr_LU', 'french_mali' => 'fr', 'french_monaco' => 'fr', 'french_morocco' => 'fr',
      'french_senegal' => 'fr', 'french_switzerland' => 'fr_CH', 'french_west_indies' => 'fr',
      'gaelic_ireland' => 'gd_IE', 'gaelic_scotland' => 'gd', 'galician' => 'gl', 'georgian' => 'ka',
      'german_austria' => 'de_AT', 'german_germany' => 'de_DE', 'german_liechtenstein' => 'de_LI',
      'german_luxembourg' => 'de_LU', 'german_switzerland' => 'de_CH', 'Greek' => 'el',
      'guarani_paraguay' => 'gn', 'gujarati' => 'gu', 'hebrew' => 'he', 'hindi' => 'hi', 'hungarian' => 'hu',
      'icelandic' => 'is', 'indonesian' => 'id', 'italian_italy' => 'it_IT', 'italian_switzerland' => 'it_CH',
      'japanese' => 'ja', 'kannada' => 'kn', 'kashmiri' => 'ks', 'kazakh' => 'kk', 'khmer' => 'km',
      'korean' => 'ko', 'lao' => 'lo', 'latin' => 'la', 'latvian' => 'lv', 'lithuanian' => 'lt',
      'malay_brunei' => 'ms_BN', 'malay_malaysia' => 'ms_MY', 'malayalam' => 'ml', 'maltese' => 'mt',
      'maori' => 'mi', 'marathi' => 'mr', 'mongolian' => 'mn', 'nepali' => 'ne', 'norwegian_bokml' => 'no_NO',
      'norwegian_nynorsk' => 'no_NO', 'oriya' => 'or', 'polish' => 'pl', 'portuguese_brazil' => 'pt_BR',
      'portuguese_portugal' => 'pt_PT', 'punjabi' => 'pa', 'raeto-romance' => 'rm', 'romanian_moldova' => 'ro_MO',
      'romanian_romania' => 'ro', 'russian' => 'ru', 'russian_moldova' => 'ru_MO', 'sanskrit' => 'sa',
      'serbian_cyrillic' => 'sr_SP', 'serbian_latin' => 'sr_SP', 'setsuana' => 'tn', 'sindhi' => 'sd',
      'slovak' => 'sk', 'slovenian' => 'sl', 'somali' => 'so', 'sorbian' => 'sb', 'spanish_argentina' => 'es_AR',
      'spanish_bolivia' => 'es_BO', 'spanish_chile' => 'es_CL', 'spanish_colombia' => 'es_CO',
      'spanish_costa_rica' => 'es_CR', 'spanish_dominican_republic' => 'es_DO', 'spanish_ecuador' => 'es_EC',
      'spanish_el_salvador' => 'es_SV', 'spanish_guatemala' => 'es_GT', 'spanish_honduras' => 'es_HN',
      'spanish_mexico' => 'es_MX', 'spanish_nicaragua' => 'es_NI', 'spanish_panama' => 'es_PA',
      'spanish_paraguay' => 'es_PY', 'spanish_peru' => 'es_PE', 'spanish_puerto_rico' => 'es_PR',
      'spanish_spain_traditional' => 'es_ES', 'spanish_spain' => 'es_ES', 'spanish_uruguay' => 'es_UY',
      'spanish_venezuela' => 'es_VE', 'swahili' => 'sw', 'swedish_finland' => 'sv_FI',
      'swedish_sweden' => 'sv_SE', 'tajik' => 'tg', 'tamil' => 'ta', 'tatar' => 'tt', 'telugu' => 'te',
      'thai' => 'th', 'tibetan' => 'bo', 'tsonga' => 'ts', 'turkish' => 'tr', 'turkmen' => 'tk',
      'ukrainian' => 'uk', 'urdu' => 'ur', 'uzbek_cyrillic' => 'uz_UZ', 'uzbek_latin' => 'uz_UZ',
      'vietnamese' => 'vi', 'welsh' => 'cy', 'xhosa' => 'xh', 'yiddish' => 'yi', 'zulu' => 'zu'
   ];
   # </editor-fold>

   # <editor-fold desc=" - $LanguagesAndIds - ">
   /**
    * Defines the english named languages as keys (in lower case) and the associated 2 char language ids as values
    * (also in lower case).
    *
    * @var    array
    */
   public static $LanguagesAndIds = [
      'german' => 'de', 'french' => 'fr', 'english' => 'en', 'spanish' => 'es', 'czech' => 'cs', 'polish' => 'pl',
      'belarusian' => 'be', 'dutch' => 'nl', 'portuguese' => 'pt', 'arabic' => 'ar', 'basque' => 'eu',
      'bulgarian' => 'bg', 'catalan' => 'ca', 'chinese' => 'zh', 'croatian' => 'hr', 'danish' => 'da',
      'estonian' => 'et', 'faroese' => 'fo', 'finnish' => 'fi', 'georgian' => 'ka', 'greek' => 'el',
      'hebrew' => 'he', 'hindi' => 'hi', 'hungarian' => 'hu', 'vietnamese' => 'vi', 'ukrainian' => 'uk',
      'turkish' => 'tr', 'thai' => 'th', 'telugu' => 'te', 'tatar' => 'tt', 'tamil' => 'ta', 'syriac' => 'syr',
      'swedish' => 'sv', 'slovenian' => 'sl', 'slovak' => 'sk', 'serbian' => 'sr', 'sanskrit' => 'sa',
      'romanian' => 'ro', 'punjabi' => 'pa', 'norwegian' => 'no', 'nynorsk' => 'nn', 'mongolian' => 'mn',
      'marathi' => 'mr', 'malay' => 'ms', 'macedonian' => 'mk', 'lithuanian' => 'lt', 'latvian' => 'lv',
      'kyrgyz' => 'ky', 'korean' => 'ko', 'konkani' => 'kok', 'kazakh' => 'kk', 'kannada' => 'kn',
      'japanese' => 'ja', 'indonesian' => 'id', 'icelandic' => 'is', 'italian' => 'it', 'ita' => 'it',
      'russian' => 'ru'
   ];
   # </editor-fold>

   # <editor-fold desc=" - $LocalizedLanguagesAndIds - ">
   /**
    * Defines the localized named languages as keys and the associated 2 char language ids as values
    * (in lower case).
    *
    * @var    array
    */
   public static $LocalizedLanguagesAndIds = [
      'deutsch' => 'de', 'français' => 'fr', 'english' => 'en', 'español' => 'es', 'čeština' => 'cs',
      'polski' => 'pl', 'беларускі' => 'be', 'nederlands' => 'nl', 'português' => 'pt', 'العربية' => 'ar',
      'basque' => 'eu', 'български' => 'bg', 'català' => 'ca', '中国的' => 'zh', 'hrvatski' => 'hr', 'dansk' => 'da',
      'eesti' => 'et', 'faroese' => 'fo', 'suomalainen' => 'fi', 'ქართული' => 'ka', 'ελληνικά' => 'el',
      'עִברִית' => 'he', 'हिंदी' => 'hi', 'magyar' => 'hu', 'Việt' => 'vi', 'український' => 'uk',
      'Türk' => 'tr', 'ภาษาไทย' => 'th', 'telugu' => 'te', 'татарский' => 'tt', 'தமிழ்' => 'ta', 'syriac' => 'syr',
      'svenska' => 'sv', 'slovenščina' => 'sl', 'slovenská' => 'sk', 'српски' => 'sr', 'sanskrit' => 'sa',
      'român' => 'ro', 'ਪੰਜਾਬੀ' => 'pa', 'norsk' => 'no', 'nynorsk' => 'nn', 'монгол' => 'mn',
      'मराठी' => 'mr', 'melayu' => 'ms', 'македонски' => 'mk', 'lietuvos' => 'lt', 'Latvijas' => 'lv',
      'kyrgyz' => 'ky', '한국의' => 'ko', 'konkani' => 'kok', 'kazakh' => 'kk', 'ಕನ್ನಡ' => 'kn',
      '日本の' => 'ja', 'indonesia' => 'id', 'Icelandic' => 'is', 'italiano' => 'it', 'русский' => 'ru'
   ];
   # </editor-fold>

   # <editor-fold desc=" - $LanguageCountries - ">
   /**
    * Here all 2 char language IDs are defined as the keys (lowercase). The values are numeric indicated arrays
    * containing a 2 char country ID, associated with the language (uppercase)
    *
    * @var    array
    */
   public static $LanguageCountries = [
      'es' => array('ES', 'AR', 'BO', 'CL', 'CO', 'CR', 'DO', 'EC', 'SV', 'GT', 'HN', 'MX', 'NI', 'PA', 'PY', 'PE', 'PR', 'UY', 'VE'),
      'ar' => array('AE', 'BH', 'DZ', 'EG', 'IQ', 'JO', 'KW', 'LB', 'IN', 'LY', 'MA', 'OM', 'QA', 'SA', 'SY', 'TN', 'YE'),
      'en' => array('US', 'AU', 'BZ', 'CA', 'CB', 'IE', 'JM', 'NZ', 'PH', 'ZA', 'TT', 'GB', 'ZW'),
      'zh' => array('CN', 'HK', 'MO', 'CHS', 'SG', 'TW', 'CHT'),
      'de' => array('DE', 'AT', 'CH', 'IT', 'LI', 'LU', 'NA'),
      'fr' => array('FR', 'BE', 'CA', 'LU', 'MC', 'CH'),
      'cs' => array('CZ'),       'pl' => array('PL'),       'be' => array('BY'),
      'nl' => array('NL', 'BE'), 'pt' => array('PT', 'BR'),
      'eu' => array('ES'),       'bg' => array('BG'),       'ca' => array('ES'),
      'hr' => array('HR'),       'da' => array('DK'),       'et' => array('EE'),
      'fo' => array('FO'),       'fi' => array('FI'),       'ka' => array('GE'),
      'el' => array('GR'),       'he' => array('IL'),       'hi' => array('IN'),
      'hu' => array('HU'),       'vi' => array('VI'),       'uk' => array('UA'),
      'tr' => array('TR'),       'th' => array('TH'),       'te' => array('IN'),
      'tt' => array('RU'),       'ta' => array('IN'),       'syr' => array('SY'),
      'sv' => array('SE', 'FI'), 'sl' => array('SI'),       'sk' => array('SK'),
      'sr' => array('SP'),       'sa' => array('IN'),       'ro' => array('RO'),
      'pa' => array('IN'),       'no' => array('NO'),       'nn' => array('NO'),
      'mn' => array('MN'),       'mr' => array('IN'),       'ms' => array('MY', 'BN'),
      'mk' => array('MK'),       'lt' => array('LT'),       'lv' => array('LV'),
      'ky' => array('KG'),       'ko' => array('KR'),       'kok' => array('IN'),
      'kk' => array('KZ'),       'kn' => array('IN'),       'ja' => array('JP'),
      'id' => array('ID'),       'is' => array('IS'),       'it' => array('IT'),
      'ru' => array('RU')
   ];
   # </editor-fold>

   # <editor-fold desc=" - $Countries - ">
   /**
    * @var array
    */
   public static $Countries = array(
      'DE' => 'germany', 'FR' => 'france', 'ES' => 'spain', 'CZ' => 'czechia',
      'PL' => 'poland', 'NL' => 'netherlands', 'PT' => 'portugal', 'BG' => 'bulgaria',
      'AR' => 'argentina', 'BO' => 'bolivia', 'CL' => 'chile', 'CO' => 'colombia', 'CR' => 'costa rica',
      'DO' => 'dominican republic', 'EC' => 'ecuador', 'SV' => 'el salvador', 'GT' => 'guatemala',
      'HN' => 'honduras', 'MX' => 'mexico', 'NI' => 'nicaragua', 'PA' => 'panama', 'PY' => 'paraguay',
      'PE' => 'peru', 'PR' => 'puerto rico', 'UY' => 'uruguay', 'VE' => 'venezuela',
      'AE' => 'united arab emirates', 'BH' => 'bahrain', 'DZ' => 'algeria', 'EG' => 'egypt', 'IQ' => 'iraq',
      'JO' => 'jordan', 'KW' => 'kuwait', 'LB' => 'lebanon', 'IN' => 'india', 'LY' => 'libya', 'MA' => 'morocco',
      'OM' => 'oman', 'QA' => 'qatar', 'SA' => 'saudi arabia', 'SY' => 'syria', 'TN' => 'tunisia',
      'YE' => 'yemen', 'US' => 'usa', 'AU' => 'australia', 'BZ' => 'belize', 'CA' => 'canada',
      'CB' => 'caribbean', 'IE' => 'ireland', 'JM' => 'jamaica', 'NZ' => 'new zealand', 'PH' => 'philippines',
      'ZA' => 'south africa', 'TT' => 'trinidad and tobago', 'GB' => 'united kingdom', 'ZW' => 'zimbabwe',
      'CN' => 'china', 'HK' => 'hongkong', 'MO' => 'macao', 'SG' => 'singapore', 'TW' => 'taiwan',
      'AT' => 'austria', 'CH' => 'switzerland', 'IT' => 'italy', 'LI' => 'liechtenstein', 'LU' => 'luxembourg',
      'NA' => 'namibia', 'BE' => 'belgium', 'MC' => 'monaco', 'BY' => 'belarus', 'BR' => 'brazil',
      'HR' => 'croatia', 'DK' => 'denmark', 'EE' => 'estonia', 'FO' => 'faroe islands', 'FI' => 'finland',
      'GE' => 'georgia', 'GR' => 'greece', 'IL' => 'israel', 'HU' => 'hungary', 'VI' => 'vietnam',
      'UA' => 'ukraine', 'TR' => 'turkey', 'TH' => 'thailand', 'RU' => 'russia',
      'SE' => 'sweden', 'SK' => 'slovakia', 'SI' => 'slovenia', 'SP' => 'serbia', 'RO' => 'romania',
      'NO' => 'norway', 'MN' => 'mongolia', 'MY' => 'malaysia', 'BN' => 'brunei', 'MK' => 'macedonia',
      'LT' => 'lithuania', 'LV' => 'latvia', 'KG' => 'kyrgyzstan', 'KR' => 'korea', 'KZ' => 'jazakhstan',
      'JP' => 'japan', 'ID' => 'indonesia', 'IS' => 'island'
   );
   # </editor-fold>

   // </editor-fold>


   // <editor-fold desc="// – – –   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –">

   /**
    * Converts a windows locale definition like <code style="color: blue">German_Germany</code> or
    * <code style="color: blue">German-Luxembourg.utf-8</code> to a LCID like <code style="color: blue">de_DE</code>
    * or <code style="color: blue">de_LU.utf-8</code>.
    *
    * @param  string $windowsLocaleDefinition THe locale definition in windows style
    * @return string Returns the LCID, or (bool)FALSE if $windowsLocaleDefinition is not a win locale definition.
    */
   public static function ConvertWinToLCID( string $windowsLocaleDefinition )
   {

      // split the definition, at first dot '.' into 2 elements
      $tmp = \explode( '.', $windowsLocaleDefinition, 2 );

      // if splitting results with 2 elements, the last one ist a character set definition, else its empty
      $charset = isset( $tmp[ 1 ] )
         ? ( '.' . \trim( $tmp[ 1 ] ) )
         : '';

      // Normalize the locale definition
      $localeDef = \rtrim(
         \preg_replace(
            '~[^a-z_]+~',
            '_',
            \strtolower( \trim( $tmp[ 0 ] ) )
         ),
         '_'
      );

      // If locale definition is unknown return FALSE
      if ( ! isset( self::$WindowsLocales[ $localeDef ] ) )
      {
         return false;
      }

      // return the LCID
      return self::$WindowsLocales[ $localeDef ] . $charset;

   }

   /**
    * Converts LCID like <code style="color: blue">de_DE</code> or <code style="color: blue">de_LU.utf-8</code>
    * to a windows locale definition like <code style="color: blue">German_Germany</code> or
    * <code style="color: blue">German-Luxembourg.utf-8</code>.
    *
    * @param  string $lcId The LCID
    * @return string Returns the windows locale definition, or (bool)FALSE if $lcid is not a known LCID.
    */
   public static function ConvertLCIDToWin( string $lcId )
   {

      // Split at first '@' into max. 2 elements
      $tmp1      = \explode( '@', $lcId, 2 );

      // Split all before '@' at first dot '.' into max. 2 elements
      $tmp2      = \explode( '.', $tmp1[ 0 ], 2 );

      // Getting the character set (if defined)
      $charset   = isset( $tmp2[ 1 ] )
         ? ( '.' . \trim( $tmp2[ 1 ] ) )
         : '';

      // split the locale definition
      $localeDef = \preg_split( '~[^a-zA-Z]+~', \trim( $tmp2[ 0 ] ), 2, \PREG_SPLIT_NO_EMPTY );

      // Check the locale definition (at least it must us 2 elements, 2 characters for each element)
      if ( 2 !== \count( $localeDef ) || 2 !== \strlen( $localeDef[ 0 ] ) || 2 !== \strlen( $localeDef[ 1 ] ) )
      {
         return false;
      }

      // Rebuild the LCID string with the required format (e.g.: de_AT)
      $lcidStr = \strtolower( $localeDef[ 0 ] ) . '_' . \strtoupper( $localeDef[ 1 ] );

      // If defined Locale is unknown return false
      if ( false === ( $winLocale = \array_search( $lcidStr, self::$WindowsLocales, true ) ) )
      {
         return false;
      }

      // Return the Windows locale with a may appended charset
      return $winLocale . $charset;

   }

   /**
    * Converts a language definition to a ISO 2 char language ID. $language can be a english language name, or a
    * language name in the language it self (e.g.: deutsch or русский)
    *
    * @param  string $language The language definition.
    * @return string Return the language ID or (bool)FALSE if no ID is found.
    */
   public static function ToLID( string $language )
   {

      // If language is defined by 2 characters (a-z) directly return it in lowercase
      if ( \preg_match( '~^[A-Za-z]{2}$~', $language ) )
      {
         return \strtolower( $language );
      }

      // If its defined as known language name (english) return the known LID
      if ( isset( self::$LanguagesAndIds[ $language ] ) )
      {
         return self::$LanguagesAndIds[ $language ];
      }

      // If its defined as known localized language name return the known LID
      if ( isset( self::$LocalizedLanguagesAndIds[ $language ] ) )
      {
         return self::$LocalizedLanguagesAndIds[ $language ];
      }

      // Test also in lowercase
      $languageLower = \strtolower( $language );
      if ( isset( self::$LanguagesAndIds[ $languageLower ] ) )
      {
         return self::$LanguagesAndIds[ $languageLower ];
      }
      if ( isset( self::$LocalizedLanguagesAndIds[ $languageLower ] ) )
      {
         return self::$LocalizedLanguagesAndIds[ $languageLower ];
      }

      // Return FALSE, if $language is unknown
      return false;

   }

   /**
    * Returns the LID (2 char language ID) associated to the country with the defined CID (2 char country ID)
    *
    * @param  string $cid The 2 char country ID (e.g.: DE, FR, etc)
    * @return string Returns the 2 char language ID (LID) or (bool)FALSE if $cid is unknown.
    */
   public static function CIDToLID( string $cid )
   {

      // If $cid is not defined by 2 characters in range a-zA-Z it returns FALSE
      if ( ! \preg_match( '~^[A-Za-z]{2}$~', $cid ) )
      {
         return false;
      }

      // Switch the CID to lower case
      $cidUpper = \strtoupper( $cid );

      // Find it
      foreach ( self::$LanguageCountries as $lid => $data )
      {
         // Return it if found
         if ( \in_array( $cidUpper, $data, true ) )
         {
            return $lid;
         }
      }

      // Return false if not found
      return false;

   }

   /**
    * Expands the defined LCID (Language-Country ID) to 3 elements LID, CID and charset.
    *
    * @param  string $lcid    The LCID to expand
    * @param  string $lid     Returns the resulting LID (Language ID)
    * @param  string $cid     Returns the resulting CID (Country ID)
    * @param  string $charset Returns the resulting Charset (can be empty!)
    */
   public static function ExpandLCID( string $lcid, string &$lid, string &$cid, string &$charset )
   {

      // ignore things like @euro at the end of a LCID
      $tmp1    = \explode( '@', $lcid, 2 );

      // Split at first dot '.' to max 2 elements
      $tmp2    = \explode( '.', $tmp1[ 0 ], 2 );

      // Init resulting values with empty strings
      $charset = '';
      $cid     = '';

      // If charset is defined.
      if ( 2 === \count( $tmp2 ) )
      {
         $charset = $tmp2[ 1 ];
      }

      // Split the rest (before the charset) at first '_' or '-' into max. 2 elements
      $result = \preg_split( '~[_-]~', $tmp2[ 0 ], 2 );

      // get the LID
      $lid = $result[0];

      // Get the CID if defined
      if ( 2 === \count( $result ) )
      {
         $cid = $result[1];
      }

   }

   // </editor-fold>


}

