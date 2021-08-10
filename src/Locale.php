<?php
/**
 * @author      Ni Irrty <niirrty+code@gmail.com>
 * @copyright   © 2017-2021, Niirrty
 * @package     Niirrty\Locale
 * @since       2017-10-31
 * @version     0.4.0
 */


declare( strict_types = 1 );


namespace Niirrty\Locale;


/**
 * Defines the Locale class.
 *
 * There are different sources where a locale can come from.
 *
 * For it i have implemented 5 different ways + the constructor to initialize a locale.
 *
 * You can use it in combination like
 *
 * <code>
 * function initLocale()
 * {
 *    if ( Locale::TryParseUrlPath( $refLocale ) )
 *    {
 *       return $refLocale;
 *    }
 *    if ( Locale::TryParseBrowserInfo( $refLocale ) )
 *    {
 *       return $refLocale;
 *    }
 *    if ( Locale::TryParseArray( $refLocale, $_POST, [ 'locale', 'language' ] ) )
 *    {
 *       return $refLocale;
 *    }
 *    if ( Locale::TryParseArray( $refLocale, $_SESSION, [ 'locale' ] ) )
 *    {
 *       return $refLocale;
 *    }
 *    if ( Locale::TryParseSystem( $refLocale ) )
 *    {
 *       return $refLocale;
 *    }
 *    return new Locale( 'de', 'AT', 'UTF-8' );
 * }
 * </code>
 *
 * but {@see \Niirrty\Locale\Locale::Create()} does finally the same.
 *
 * @since  v0.1.0
 */
final class Locale
{


    #region // – – –   P R I V A T E   F I E L D S   – – – – – – – – – – – – – – – – – – – – – – – –

    /**
     * All current used locale strings
     *
     * @type   array
     */
    private array $_locales;

    private string $country;

    private string $charset;

    #endregion


    #region // – – –   P R I V A T E   S T A T I C   F I E L D S   – – – – – – – – – – – – – – – – –

    /**
     * The global locale instance, if assigned
     *
     * @var Locale|null
     */
    private static ?Locale $_instance;

    #endregion


    #region // – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –

    /**
     * Init a new instance
     *
     * @param string      $language The current used language (2 characters in lower case. e.g.: 'de')
     * @param string|null $country  The optional country id (2 characters in upper case. e.g.: 'AT')
     * @param string|null $charset  The optional charset (e.g. 'UTF-8')
     */
    public function __construct(
        private string $language, ?string $country = null, ?string $charset = null )
    {

        $this->country  = $country ?? '';
        $this->charset  = $charset ?? '';
        $this->_locales  = [];

        // For windows systems we are doing this way
        if ( LocaleHelper::IsWindowsOS() &&
            ( false !== ( $lcStr = LocaleHelper::ConvertLCIDToWin( (string) $this ) ) ) )
        {

            // explode the windows locale string at first underscore character (max. 2 resulting elements)
            $tmp = \explode( '_', $lcStr, 2 );

            // The LID is always element 0
            $lid = $tmp[ 0 ];

            // The CID is element 1, if defined
            $cid = ! empty( $tmp[ 1 ] ) ? $tmp[ 1 ] : '';

            // Init a empty character set. We must find it now, if defined
            $cset = '';

            // Search only for character set definition if a CID is defined
            if ( ! empty( $cid ) )
            {

                // explode at dot '.'. It separates the CID from a defined character set
                $tmp = \explode( '.', $cid, 2 );

                // If a character set is defined
                if ( 2 === \count( $tmp ) )
                {

                    // Assign the character set to the variable
                    $cset .= $tmp[ 1 ];

                    // Remove the charset from the CID
                    $cid   = $tmp[ 0 ];

                    // Build all usable Locales
                    $this->addLocaleStrings( $lid, $cid, $cset );
                    $this->addLocaleStrings( $language, $country, $charset );

                }
                // There is no character set defined
                else
                {

                    // Build all usable Locales
                    $this->addLocaleStrings( $lid, $cid );
                    $this->addLocaleStrings( $language, $country );

                }

            }
            // No usable character set
            else
            {
                $this->_locales[] = $lid;
            }

        }
        // Here we go for non windows systems
        else
        {

            // If a charset is defined, so also a country (CID) and language (LID) must be defined
            if ( ! empty( $charset ) )
            {
                $this->addLocaleStrings( $language, $country, $country );
            }

            // If a CID + LID is defined, but not a charset
            else if ( ! empty ( $country ) )
            {
                $this->addLocaleStrings( $language, $country );
            }

            // There is only a LID defined
            else
            {
                $this->_locales[] = $language;
            }

        }

        $this->_locales = \array_values( \array_unique( $this->_locales ) );
        // Set current before defined locales only for some date+time functionality. Rest in peace… for all other :-)
        \setlocale( \LC_TIME, $this->_locales );

    }

    #endregion


    #region // – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –

    #region // - - -   G E T T E R   - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Returns the current defined 2 char language ID
     *
     * @return string
     */
    public function getLID() : string
    {

        return $this->language;

    }

    /**
     * This is a alias of {@see \Niirrty\Locale\Locale::getLID()}.
     *
     * @return string
     */
    public function getLanguage() : string
    {

        return $this->getLID();

    }

    /**
     * Returns the current defined 2 char country ID, or a empty string if none is defined
     *
     * @return string
     */
    public function getCID() : string
    {

        return $this->country;

    }

    /**
     * This is a alias of {@see \Niirrty\Locale\Locale::getCID()}.
     *
     * @return string
     */
    public function getCountry() : string
    {

        return $this->getCID();

    }

    /**
     * Returns the current defined charset, or a empty string if none is defined
     *
     * @return string
     */
    public function getCharset() : string
    {

        return $this->charset;

    }

    /**
     * Returns the current used locale strings.
     *
     * @return array
     */
    public function getLocaleStrings() : array
    {

        return $this->_locales;

    }

    #endregion

    /**
     * Overrides the magic __toString method.
     *
     * @return string
     */
    public function __toString() : string
    {

        return $this->language
             .  ( ! empty( $this->country ) ? '_' . $this->country : '' )
             .  ( ! empty( $this->charset ) ? '.' . $this->charset : '' );

    }

    /**
     * Register the current instance as globally available Locale instance.
     *
     * @return Locale
     */
    public function registerAsGlobalInstance() : Locale
    {

        Locale::$_instance = $this;
        return $this;

    }

    #endregion


    #region // – – –   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –

    /**
     * Tries to create a new Locale instance from an specific URL path part. If no URL path part is defined
     * it uses $_SERVER[ 'REQUEST_URI' ] or $_SERVER[ 'SCRIPT_URL' ] otherwise.
     *
     * @param Locale|null $refLocale Returns the Locale instance if the method return TRUE.
     * @param string|null $urlPath
     *
     * @return bool
     */
    public static function TryParseUrlPath( ?Locale &$refLocale = null, string $urlPath = null ) : bool
    {

        if ( empty( $urlPath ) )
        {

            // Get URL path from $_SERVER[ 'REQUEST_URI' ] or $_SERVER[ 'SCRIPT_URL' ]

            if ( isset( $_SERVER[ 'REQUEST_URI' ] ) )
            {
                $urlPath = $_SERVER[ 'REQUEST_URI' ];
            }
            else
            {
                if ( ! isset( $_SERVER[ 'SCRIPT_URL' ] ) )
                {
                    return false;
                }
                $urlPath = $_SERVER[ 'SCRIPT_URL' ];
            }

        }

        // IF the value does not match the required data format stop this method here
        //
        if ( ! \preg_match( '~^/([a-zA-Z]{2})([_-]([a-zA-Z]{2})(\\.([a-zA-Z0-9-]+))?)?/~', $urlPath, $matches ) )
        {
            return false;
        }

        // Everything is OK. Init the new instance and return TRUE
        $refLocale = self::matchesToLocale( $matches );

        return true;

    }

    /**
     * Tries to create a new Locale instance from defined array. It accepts one of the following array keys by default:
     *
     * - 'locale'
     * - 'language'
     * - 'lang'
     * - 'loc'
     * - 'lc'
     * - 'lng'
     *
     * @param Locale|null $refLocale   Returns the Locale instance if the method return TRUE.
     * @param  array      $requestData The array with the data that should be used for getting local info from.
     * @param  array      $acceptedKeys
     *
     * @return bool
     */
    public static function TryParseArray(
        ?Locale &$refLocale, array $requestData, array $acceptedKeys = [ 'locale', 'language', 'lang', 'loc', 'lc', 'lng' ] )
        : bool
    {

        if ( \count( $requestData ) < 1 )
        {
            // Ignore empty arrays
            return false;
        }

        $requestData  = \array_change_key_case( $requestData , \CASE_LOWER );
        $acceptedKeys = \array_change_key_case( $acceptedKeys, \CASE_LOWER );
        $localeString = null;

        foreach ( $acceptedKeys as $key )
        {

            if ( ! isset( $requestData[ $key ] ) )
            {
                continue;
            }

            $localeString = \trim( $requestData[ $key ] );

            break;

        }

        if ( empty( $localeString ) ) { return false; }

        if ( ! \preg_match( '~^([a-zA-Z]{2})([_-]([a-zA-Z]{2})(\\.([a-zA-Z0-9-]+))?)?$~', $localeString, $matches ) )
        {
            return false;
        }

        // Everything is OK. Init the new instance and return TRUE
        $refLocale = self::matchesToLocale( $matches );

        return true;

    }

    /**
     * Tries to create a new Locale instance from underlying system/OS locale settings.
     *
     * @param Locale|null $refLocale Returns the Locale instance if the method return TRUE.
     * @return bool
     */
    public static function TryParseSystem( ?Locale &$refLocale = null ) : bool
    {

        // Getting the current system used locale of LC_ALL
        $lcString = \setlocale( \LC_ALL, '0' );

        // Ignore values with lower than 2 characters. It also ignores the 'C' locale
        if ( empty( $lcString ) || 2 > \strlen( $lcString ) )
        {
            return false;
        }

        // Handle windows different from other OS
        if ( LocaleHelper::IsWindowsOS() )
        {

            $tmp = \explode( ';', $lcString );

            $foundLocale = false;
            $localeData  = [ 'language' => null, 'country' => null, 'charset' => null ];

            // Loop the exploded elements
            foreach ( $tmp as $element )
            {

                // Explode at the first equal sign '='
                $tmp2 = \explode( '=', $element, 2 );

                // If the explode before results in only one element (no '=' inside $element found)
                if ( 2 > \count( $tmp2 ) )
                {
                    // Convert to LCID. If it fails ignore this $element
                    if ( false === ( $lcid = LocaleHelper::ConvertWinToLCID( $element ) ) )
                    {
                        continue;
                    }
                    // Get the elements of the current LCID
                    $localeData = LocaleHelper::ExpandLCID( $lcid );
                    // Create a new instance and return TRUE
                    $refLocale = new Locale( $localeData[ 'language' ], $localeData[ 'country' ] ?? '', $localeData[ 'charset' ] ?? '' );
                    return true;
                }

                // Ignore 'LC_TYPE' locale types
                if ( 'LC_CTYPE' === \strtoupper( $tmp2[ 0 ] ) )
                {
                    continue;
                }

                // Convert the value (after the =) to a LCID. If it fails ignore this $element
                if ( false === ( $lcid = LocaleHelper::ConvertWinToLCID( $tmp2[ 1 ] ) ) )
                {
                    continue;
                }

                // Get the elements of the current LCID
                $localeData  = LocaleHelper::ExpandLCID( $lcid );
                $foundLocale = true;

                break;

            }

            if ( $foundLocale )
            {
                $refLocale = new Locale( $localeData[ 'language' ], $localeData[ 'country' ] ?? '', $localeData[ 'charset' ] ?? '' );
                return true;
            }

            // Return false if no usable locale is found by this way
            return false;

        }

        // No windows systems
        if ( ! \preg_match( '~^[a-z]{2}([_-][a-z]{2})?(@[a-z_-]+)?(\.[a-z0-9_-]{1,14})?$~i', $lcString ) )
        {
            // A unknown locale string format
            return false;
        }

        $localeData = LocaleHelper::ExpandLCID( $lcString );

        $refLocale = new Locale( $localeData[ 'language' ], $localeData[ 'country' ] ?? '', $localeData[ 'charset' ] ?? '' );

        return true;

    }

    /**
     * Tries to create a new Locale instance from browser defined Accept-Language header.
     *
     * @param Locale|null $refLocale Returns the Locale instance if the method return TRUE.
     * @return bool
     */
    public static function TryParseBrowserInfo( ?Locale &$refLocale = null ) : bool
    {

        // If init by browser info is disabled, or the required $_SERVER['HTTP_ACCEPT_LANGUAGE'] is not defined
        if ( ! isset( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] ) )
        {
            return false;
        }

        // Format like: de-de,de;q=0.8,en-us;q=0.5,en;q=0.3
        $tmp = \explode( ',', $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] );

        // Iterate over each exploded element
        foreach ( $tmp as $t )
        {

            // Explode each element at first semicolon ';' to max. 2 sub elements
            $tmp2 = \explode( ';', $t, 2 );
            // Explode the first sub element (must be a LCID) at '-' into LID and CID
            $tmp3 = \explode( '-', $tmp2[ 0 ], 2 );

            // If last explode result not with 2 sub elements explode at '_' into LID and CID
            if ( \count( $tmp3 ) < 2 )
            {
                $tmp3 = \explode( '_', $tmp2[ 0 ], 2 );
            }

            // If last explode result not with 2 sub elements use only the LID
            if ( \count( $tmp3 ) < 2 )
            {
                $tmp3 = [ $tmp2[ 0 ] ];
            }

            $la   = \trim( $tmp3[ 0 ] );
            // If the LID do not use 2 characters ignore this element and restart with the next
            if ( 2 !== \strlen( $la ) )
            {
                continue;
            }

            // Init a empty CID
            $co = null;
            // Init a empty charset
            $cs = null;

            // If there are more than 1 sub elements extracted from current element
            if ( isset( $tmp3[ 1 ] ) )
            {
                // Explode the second sub element at first point '.'. It separates the CID from the optional character set.
                $tmp2 = \explode( '.', $tmp3[ 1 ], 2 );
                // Assign the CID
                $co   = \trim( $tmp2[ 0 ] );
                // A charset is defined, assign it
                if ( isset( $tmp2[ 1 ] ) )
                {
                    $cs = \trim( $tmp2[ 1 ] );
                }
                // clear the CID if its not defined by 2 characters
                if ( 2 !== \strlen( $co ) )
                {
                    $co = null;
                }
                // Otherwise convert the CID to lower case
                else
                {
                    $co = \strtoupper ( $co );
                }
            }

            // Init the new Locale instance and return it.
            $refLocale = new Locale( $la, $co ?? '', $cs ?? '' );

            return true;

        }

        // return FALSE if no usable local here was found.
        return false;

    }

    /**
     * Creates a locale with all available methods. If no method can create a Locale the defined fallback locale is used.
     *
     * First a locale
     *
     * @param  Locale $fallbackLocale
     * @param  bool                   $useUrlPath
     * @param  array                  $acceptedRequestParams
     * @return Locale
     */
    public static function Create(
        Locale $fallbackLocale, bool $useUrlPath = true, array $acceptedRequestParams = [ 'locale', 'language', 'lang' ] )
        : Locale
    {

        if ( $useUrlPath && Locale::TryParseUrlPath( $refLocale ) )
        {
            return $refLocale;
        }

        if ( Locale::TryParseBrowserInfo( $refLocale ) )
        {
            return $refLocale;
        }

        if ( Locale::TryParseSystem( $refLocale ) )
        {
            return $refLocale;
        }

        if ( \count( $acceptedRequestParams ) > 0 )
        {

            if ( Locale::TryParseArray( $refLocale, $_POST, $acceptedRequestParams ) )
            {
                return $refLocale;
            }

            if ( Locale::TryParseArray( $refLocale, $_GET, $acceptedRequestParams ) )
            {
                return $refLocale;
            }

            /** @noinspection UnSafeIsSetOverArrayInspection */
            if ( isset( $_SESSION ) && Locale::TryParseArray( $refLocale, $_SESSION, $acceptedRequestParams ) )
            {
                return $refLocale;
            }

        }

        return $fallbackLocale;

    }

    /**
     * Gets if a global available instance exists.
     *
     * @return bool
     */
    public static function HasGlobalInstance() : bool
    {

        return null !== self::$_instance;

    }

    /**
     * Gets the global available instance or NULL if none is registered.
     *
     * @return Locale|null
     */
    public static function GetGlobalInstance(): ?Locale
    {

        return self::$_instance;

    }

    #endregion


    private function addLocaleStrings( string $language, ?string $country = null, ?string $charset = null )
    {

        if ( empty( $charset ) )
        {
            $this->_locales[] = $language;
            if ( ! empty( $country ) )
            {
                $this->_locales[] = $language . '_' . $country;
                $this->_locales[] = $language . '-' . $country;
            }
        }
        else if ( empty( $country ) )
        {
            $this->_locales[] = $language;
            $this->_locales[] = $language . '.' . $charset;
        }
        else
        {
            $this->_locales[] = $language;
            $this->_locales[] = $language . '_' . $country;
            $this->_locales[] = $language . '-' . $country;
            $this->_locales[] = $language . '.' . $charset;
            $this->_locales[] = $language . '_' . $country . '.' . $charset;
            $this->_locales[] = $language . '-' . $country . '.' . $charset;
        }

    }

    private static function matchesToLocale( array $matches ) : Locale
    {

        $lid = \strtolower( $matches[ 1 ] );

        $cid = empty( $matches[ 2 ] )
            ? null
            : \strtoupper( $matches[ 3 ] );

        $charset = empty( $matches[ 4 ] )
            ? null
            : $matches[ 5 ];

        return new Locale( $lid, $cid ?? '', $charset ?? '' );

    }


}

