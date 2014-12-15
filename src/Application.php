<?php
/*************************************************************************************
 *  Copyright (C) 2014 by Alejandro Fiestas Olivares <afiestas@kde.org>              *
 *                                                                                   *
 *  This program is free software; you can redistribute it and/or                    *
 *  modify it under the terms of the GNU Affero General Public License               *
 *  as published by the Free Software Foundation; either version 2                   *
 *  of the License, or (at your option) any later version.                           *
 *                                                                                   *
 *  This program is distributed in the hope that it will be useful,                  *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of                   *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                    *
 *  GNU General Public License for more details.                                     *
 *                                                                                   *
 *  You should have received a copy of the GNU Affero General Public License         *
 *  along with this program; if not, write to the Free Software                      *
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA   *
 *************************************************************************************/

namespace AFiestas\ProtectFont;

class Application
{
    private $settings;
    private $fontSettings;

    public function __construct($settings, $fontSettings)
    {
        $this->settings = $settings;
        $this->fontSettings = $fontSettings;
    }

    public function run($getRequest)
    {
        //Parse request and get the font information
        $request = new Request($getRequest);
        $font = $request->getFont();

        $filter = new Filter($this->fontSettings);
        $shouldContinue = $filter->filterAccess($font['originalName']);
        if (!$shouldContinue) {
            echo ':)';
            return $filter->lastFiltered();
        }

        //Get the actual file
        $fontLocator = new FontLocator($this->settings, $this->fontSettings);
        $fontPath = $fontLocator->getFontPath($font['originalName']);

        $printerProvider = new PrinterProvider();
        $printer = $printerProvider->loadPrinter($font['method']);

        $printer->printFont($fontPath);
    }
}