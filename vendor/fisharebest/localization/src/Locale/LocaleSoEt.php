<?php

namespace Fisharebest\Localization\Locale;

use Fisharebest\Localization\Territory\TerritoryEt;

/**
 * Class LocaleSoEt
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class LocaleSoEt extends LocaleSo
{
    public function territory()
    {
        return new TerritoryEt();
    }
}
