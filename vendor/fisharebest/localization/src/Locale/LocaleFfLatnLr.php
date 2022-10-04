<?php

namespace Fisharebest\Localization\Locale;

use Fisharebest\Localization\Territory\TerritoryLr;

/**
 * Class LocaleFfLatn - Fulah
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class LocaleFfLatnLr extends LocaleFfLatn
{
    public function territory()
    {
        return new TerritoryLr();
    }
}
