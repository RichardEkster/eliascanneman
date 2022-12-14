<?php

namespace Fisharebest\Localization\Territory;

/**
 * Class AbstractTerritory - Representation of a geographic area.
 *
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2022 Greg Roach
 * @license   GPL-3.0-or-later
 */
abstract class AbstractTerritory
{
    /**
     * @return int
     */
    public function firstDay()
    {
        return 1;
    }

    /**
     * @return string
     */
    public function measurementSystem()
    {
        return 'metric';
    }

    /**
     * @return string
     */
    public function paperSize()
    {
        return 'A4';
    }

    /**
     * @return int
     */
    public function weekendStart()
    {
        return 6;
    }

    /**
     * @return int
     */
    public function weekendEnd()
    {
        return 0;
    }
}
