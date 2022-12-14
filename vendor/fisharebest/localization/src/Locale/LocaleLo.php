<?php

namespace Fisharebest\Localization\Locale;

use Fisharebest\Localization\Language\LanguageLo;

/**
 * Class LocaleLo - Lao
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class LocaleLo extends AbstractLocale implements LocaleInterface
{
    public function endonym()
    {
        return 'ລາວ';
    }

    public function language()
    {
        return new LanguageLo();
    }

    public function numberSymbols()
    {
        return array(
            self::GROUP   => self::DOT,
            self::DECIMAL => self::COMMA,
        );
    }
}
