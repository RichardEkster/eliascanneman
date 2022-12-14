<?php

namespace Fisharebest\Localization\Script;

/**
 * Class ScriptMlym - Representation of the Malayalam script.
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class ScriptMlym extends AbstractScript implements ScriptInterface
{
    public function code()
    {
        return 'Mlym';
    }

    public function numerals()
    {
        return array('൦', '൧', '൨', '൩', '൪', '൫', '൬', '൭', '൮', '൯');
    }

    public function number()
    {
        return '347';
    }

    public function unicodeName()
    {
        return 'Malayalam';
    }
}
