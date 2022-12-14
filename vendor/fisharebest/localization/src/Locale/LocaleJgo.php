<?php

namespace Fisharebest\Localization\Locale;

use Fisharebest\Localization\Language\LanguageJgo;

/**
 * Class LocaleJgo - Ngomba
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class LocaleJgo extends AbstractLocale implements LocaleInterface
{
    public function endonym()
    {
        return 'Ndaꞌa';
    }

    public function endonymSortable()
    {
        return 'NDAA';
    }

    public function language()
    {
        return new LanguageJgo();
    }

    public function numberSymbols()
    {
        return array(
            self::GROUP   => self::DOT,
            self::DECIMAL => self::COMMA,
        );
    }
}
