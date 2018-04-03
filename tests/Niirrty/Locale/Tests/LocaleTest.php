<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright  (c) 2017-2018 Ni Irrty
 * @license        MIT
 * @since          2018-04-01
 * @version        0.2.0
 */


namespace Niirrty\Locale\Tests
{

   use Niirrty\Locale\Locale;
   use Niirrty\Locale\LocaleHelper;
   use PHPUnit\Framework\TestCase;


   class LocaleTest extends TestCase
   {


      public function tearDown()
      {

         #\Mockery::close();
         parent::tearDown();
         
      }


      public function testConstruct()
      {

         $helper = \Mockery::mock( 'alias:\\Niirrty\\Locale\\LocaleHelper' );
         $helper->shouldReceive( 'ConvertLCIDToWin' )
                ->atMost()
                ->times(4)
                ->withAnyArgs()
                ->andReturnUsing( function( $lcDef ) { return $lcDef; } );
         $helper->shouldReceive( 'IsWindowsOS' )->atMost()->times(4)->andReturn( true );
         $helper->shouldReceive( 'ExpandLCID' )->atMost()->times(99)->andReturnUsing(
            function( string $lcid )
            {
               $output  = [
                  'language' => null,
                  'country'  => null,
                  'charset'  => null
               ];
               $tmp1    = \explode( '@', $lcid, 2 );
               $tmp2    = \explode( '.', $tmp1[ 0 ], 2 );
               if ( 2 === \count( $tmp2 ) )
               {
                  $output[ 'charset' ] = $tmp2[ 1 ];
               }
               $result = \preg_split( '~[_-]~', $tmp2[ 0 ], 2 );
               $output[ 'language' ] = $result[0];
               if ( 2 === \count( $result ) )
               {
                  $output[ 'country' ] = $result[1];
               }
               return $output;
            }
         );

         $this->assertSame( 'de_DE.utf-8', (string) new Locale( 'de', 'DE', 'utf-8' ) );
         $this->assertSame( 'de_DE.utf-8', \setlocale( LC_TIME, 0 ), 'This test will fail if the required locale is not present for your system. Just change it to a usable locale' );

         $this->assertSame( 'de_DE', (string) new Locale( 'de', 'DE' ) );

         $this->assertSame( 'de', (string) new Locale( 'de', null, null ) );

         $helper->shouldReceive( 'IsWindowsOS' )->atMost()->times(3)->andReturn( false );
         $this->assertSame( 'de', (string) new Locale( 'de', null, null ) );
         $this->assertSame( 'de_DE.utf-8', (string) new Locale( 'de', 'DE', 'utf-8' ) );
         $this->assertSame( 'de_DE.utf-8', \setlocale( LC_TIME, 0 ), 'This test will fail if the required locale is not present for your system. Just change it to a usable locale' );
         $this->assertSame( 'de_DE', (string) new Locale( 'de', 'DE' ) );

         $helper->shouldReceive( 'ConvertLCIDToWin' )->atMost()->times(99)->withAnyArgs()->andReturn( false );
         $helper->shouldReceive( 'IsWindowsOS' )->atMost()->times(99)->andReturn( false );

      }

      public function testRegisterAsGlobalInstance()
      {

         $lc = new Locale( 'de', 'DE' );
         $this->assertSame( $lc, $lc->registerAsGlobalInstance() );
         $this->assertSame( $lc, Locale::GetGlobalInstance() );

      }

      public function testGetLID()
      {

         $this->assertSame( 'de', ( new Locale( 'de' ) )->getLID() );

      }

      public function testGetLanguage()
      {

         $this->assertSame( 'de', ( new Locale( 'de' ) )->getLanguage() );

      }

      public function testGetCID()
      {

         $this->assertSame( 'DE', ( new Locale( 'de', 'DE' ) )->getCID() );

      }

      public function testGetCountry()
      {

         $this->assertSame( 'AT', ( new Locale( 'de', 'AT' ) )->getCountry() );

      }

      public function testGetCharset()
      {

         $this->assertSame( '', ( new Locale( 'de' ) )->getCharset() );
         $this->assertSame( 'utf-8', ( new Locale( 'de', 'CH', 'utf-8' ) )->getCharset() );

      }

      public function testGetLocaleStrings()
      {

         $this->assertSame(
            [ 'de_CH.utf-8', 'de-CH.utf-8', 'de_CH', 'de-CH' ],
            ( new Locale( 'de', 'CH', 'utf-8' ) )->getLocaleStrings()
         );

      }

      public function testTryParseUrlPath()
      {

         $success = Locale::TryParseUrlPath( $refLocale, '/de/blub' );
         $this->assertTrue( $success );
         $this->assertInstanceOf( Locale::class, $refLocale );
         $this->assertSame( 'de', (string) $refLocale );

         $_SERVER[ 'REQUEST_URI' ] = '/de_AT.utf-8/foo';
         $success = Locale::TryParseUrlPath( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'de_AT.utf-8', (string) $refLocale );
         unset( $_SERVER[ 'REQUEST_URI' ] );

         $_SERVER[ 'SCRIPT_URL' ] = '/de_ch/foo';
         $success = Locale::TryParseUrlPath( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'de_CH', (string) $refLocale );
         unset( $_SERVER[ 'SCRIPT_URL' ] );

         $success = Locale::TryParseUrlPath( $refLocale );
         $this->assertFalse( $success );

         $success = Locale::TryParseUrlPath( $refLocale, '/foo/bar' );
         $this->assertFalse( $success );

      }

      public function testTryParseArray()
      {

         $success = Locale::TryParseArray( $refLocale, [ 'lc' => 'de_AT.utf-8' ] );
         $this->assertTrue( $success );
         $this->assertInstanceOf( Locale::class, $refLocale );
         $this->assertSame( 'de_AT.utf-8', (string) $refLocale );
         $success = Locale::TryParseArray( $refLocale, [] );
         $this->assertFalse( $success );
         $success = Locale::TryParseArray( $refLocale, [ 'lang' => 'foo-bar' ] );
         $this->assertFalse( $success );

      }

      public function testTryParseSystem()
      {

         \setlocale( \LC_ALL, 'en_US.utf-8' );

         $success = Locale::TryParseSystem( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'en_US.utf-8', (string) $refLocale );

         \setlocale( \LC_ALL, 'de_DE.utf-8' );

         $success = Locale::TryParseSystem( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'de_DE.utf-8', (string) $refLocale );

         \setlocale( \LC_ALL, 'C' );

         $success = Locale::TryParseSystem( $refLocale );
         $this->assertFalse( $success );

      }

      public function testTryParseBrowserInfo()
      {

         $success = Locale::TryParseBrowserInfo( $refLocale );
         $this->assertFalse( $success );

         $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] = 'en-US,en;q=0.9,de-DE;q=0.8,de;q=0.7,la;q=0.6';
         $success = Locale::TryParseBrowserInfo( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'en_US', (string) $refLocale );

         $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] = 'eng,de;q=0.8,la;q=0.6';
         $success = Locale::TryParseBrowserInfo( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'de', (string) $refLocale );

         $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] = 'en-US.utf-8,en;q=0.9,de-DE;q=0.8,de;q=0.7,la;q=0.6';
         $success = Locale::TryParseBrowserInfo( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'en_US.utf-8', (string) $refLocale );

         $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] = 'en-USA.utf-8,de-DEU.utf-8;q=0.8';
         $success = Locale::TryParseBrowserInfo( $refLocale );
         $this->assertTrue( $success );
         $this->assertSame( 'en.utf-8', (string) $refLocale );

         unset( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] );

      }

      public function testCreate()
      {

         # Create( $fallbackLocale, $useUrlPath = true, $acceptedRequestParams = [ 'locale', 'language', 'lang' ] )

         $created = Locale::Create( new Locale( 'en', 'US', 'utf-8' ), true );
         $this->assertInstanceOf( Locale::class, $created );
         $this->assertSame( 'en_US.utf-8', (string) $created );

         $_SERVER[ 'REQUEST_URI' ] = '/de_AT.utf-8/foo';
         $created = Locale::Create( new Locale( 'en', 'US', 'utf-8' ), true );
         $this->assertInstanceOf( Locale::class, $created );
         $this->assertSame( 'de_AT.utf-8', (string) $created );
         unset( $_SERVER[ 'REQUEST_URI' ] );

         $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] = 'en-US.utf-8,en;q=0.9,de-DE;q=0.8,de;q=0.7,la;q=0.6';
         $created = Locale::Create( new Locale( 'en', 'GB', 'utf-8' ), false );
         $this->assertInstanceOf( Locale::class, $created );
         $this->assertSame( 'en_US.utf-8', (string) $created );
         unset( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] );

         $_POST[ 'lang' ] = 'de-AT.utf-8';
         $created = Locale::Create( new Locale( 'en', 'GB', 'utf-8' ), false );
         $this->assertInstanceOf( Locale::class, $created );
         $this->assertSame( 'de_AT.utf-8', (string) $created );
         unset( $_POST[ 'lang' ] );

         $_GET[ 'lang' ] = 'de-CH.utf-8';
         $created = Locale::Create( new Locale( 'en', 'GB', 'utf-8' ), false );
         $this->assertInstanceOf( Locale::class, $created );
         $this->assertSame( 'de_CH.utf-8', (string) $created );
         unset( $_GET[ 'lang' ] );

         $_SESSION[ 'lang' ] = 'de_IT.utf-8';
         $created = Locale::Create( new Locale( 'en', 'GB', 'utf-8' ), false );
         $this->assertInstanceOf( Locale::class, $created );
         $this->assertSame( 'de_IT.utf-8', (string) $created );
         unset( $_SESSION[ 'lang' ] );

      }

      public function testHasGlobalInstance()
      {

         $this->assertTrue( Locale::HasGlobalInstance() );

      }

      public function testConvertWinToLCID()
      {

         $this->assertSame( 'de_AT', LocaleHelper::ConvertWinToLCID( 'german_austria' ) );
         $this->assertSame( 'de_AT.utf-8', LocaleHelper::ConvertWinToLCID( 'german_austria.utf-8' ) );
         $this->assertFalse( LocaleHelper::ConvertWinToLCID( 'foo_bar' ) );

      }

      public function testConvertLCIDToWin()
      {

         $this->assertSame( 'german_austria', LocaleHelper::ConvertLCIDToWin( 'de_AT' ) );
         $this->assertSame( 'german_austria.utf-8', LocaleHelper::ConvertLCIDToWin( 'de_AT.utf-8' ) );
         $this->assertFalse( LocaleHelper::ConvertLCIDToWin( 'foo_bar' ) );
         $this->assertFalse( LocaleHelper::ConvertLCIDToWin( 'fo_ba' ) );

      }

      public function testToLID()
      {

         $this->assertSame( 'de', LocaleHelper::ToLID( 'german' ) );
         $this->assertSame( 'en', LocaleHelper::ToLID( 'en' ) );
         $this->assertSame( 'hu', LocaleHelper::ToLID( 'magyar' ) );
         $this->assertSame( 'de', LocaleHelper::ToLID( 'German' ) );
         $this->assertSame( 'pl', LocaleHelper::ToLID( 'POLSKI' ) );
         $this->assertFalse( LocaleHelper::ToLID( 'xyzEnglish' ) );

      }

      public function testCIDToLID()
      {

         $this->assertSame( 'de', LocaleHelper::CIDToLID( 'AT' ) );
         $this->assertFalse( LocaleHelper::CIDToLID( 'xx' ) );
         $this->assertFalse( LocaleHelper::CIDToLID( 'deu' ) );

      }

      public function testExpandLCID()
      {

         $this->assertSame( [ 'language' => 'de', 'country' => 'AT', 'charset' => 'utf-8' ],
                            LocaleHelper::ExpandLCID( 'de_AT.utf-8' ) );

      }

      public function testIsWindowsOS()
      {

         $this->assertSame( '\\' === \DIRECTORY_SEPARATOR, LocaleHelper::IsWindowsOS() );

      }


   }

}

