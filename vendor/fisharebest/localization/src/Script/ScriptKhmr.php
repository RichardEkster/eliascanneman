<?php

namespace Fisharebest\Localization\Script;

/**
 * Class ScriptKhmr - Representation of the Khmer script.
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
class ScriptKhmr extends AbstractScript implements ScriptInterface
{
    public function code()
    {
        return 'Khmr';
    }

    public function numerals()
    {
        return array('០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩');
    }

    public function number()
    {
        return '355';
    }

    public function unicodeName()
    {
        return 'Khmer';
    }
}
