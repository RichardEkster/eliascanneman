<?php

namespace Fisharebest\Localization\Language;

use Fisharebest\Localization\PluralRule\PluralRuleTachelhit;
use Fisharebest\Localization\Script\ScriptTfng;
use Fisharebest\Localization\Territory\TerritoryMa;

/**
 * Class LanguageShi - Representation of the Tachelhit language.
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class LanguageShi extends AbstractLanguage implements LanguageInterface
{
    public function code()
    {
        return 'shi';
    }

    public function defaultScript()
    {
        return new ScriptTfng();
    }

    public function defaultTerritory()
    {
        return new TerritoryMa();
    }

    public function pluralRule()
    {
        return new PluralRuleTachelhit();
    }
}
