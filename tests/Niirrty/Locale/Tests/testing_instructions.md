# Testing instructions

Some methods of the class `\Niirrty\Locale\LocaleHelper` must be mocked for testing the class
`\Niirrty\Locale\Locale`.

But this is bad in combination with also unit testing the `\Niirrty\Locale\LocaleHelper` class.

So the 2 tests `\Niirrty\Locale\Tests\LocaleTest` and `\Niirrty\Locale\Tests\LocaleHelperTest`
must be executed one by one and not as a suite! 