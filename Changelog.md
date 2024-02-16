# Changelog

## Version 0.6.1 `2024-02-16`

* Niirrty.Core was updated to v0.6.1, so also here an update was required.

## Version 0.6.0 `2024-02-15`

* Add a changelog
* Change property `Locale->language` to be `readonly`
* Remove default value matching `CASE_LOWER` 2nd parameter for `array_change_key_case` inside `Locale::TryParseArray(...)`
* Add `void` return type to private `Locale->addLocaleStrings(...)` method
* Remove immediately overwritten array index `language` before accessing, in `LocaleHelper::ExpandLCID(...)`