<?php

namespace Fisharebest\Localization\Language;

use Fisharebest\Localization\PluralRule\PluralRule7;
use Fisharebest\Localization\Territory\TerritoryHr;

/**
 * Class LanguageHr - Representation of the Croatian language.
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class LanguageHr extends AbstractLanguage implements LanguageInterface
{
    public function code()
    {
        return 'hr';
    }

    public function defaultTerritory()
    {
        return new TerritoryHr();
    }

    public function pluralRule()
    {
        return new PluralRule7();
    }
}
