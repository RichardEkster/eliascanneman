<?php

namespace Fisharebest\Localization\Script;

/**
 * Class ScriptShrd - Representation of the Sharada, ΕΔradΔ script.
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class ScriptShrd extends AbstractScript implements ScriptInterface
{
    public function code()
    {
        return 'Shrd';
    }

    public function numerals()
    {
        return array('π', 'π', 'π', 'π', 'π', 'π', 'π', 'π', 'π', 'π');
    }

    public function number()
    {
        return '319';
    }

    public function unicodeName()
    {
        return 'Sharada';
    }
}
