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

