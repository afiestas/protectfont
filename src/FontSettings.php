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

class FontSettings
{
    private $settings;
    function __construct($settingsFile = null)
    {
        $settingsFile = file_get_contents($settingsFile);
        $this->settings = json_decode($settingsFile, true /*assoc*/);
    }

    public function fontExists($fontName)
    {
        return array_key_exists($fontName, $this->settings);
    }

    public function getFontDomains($fontName)
    {
        return $this->settings[$fontName]["domains"];
    }

    public function getFontPath($fontName)
    {
        return $this->settings[$fontName]["path"];
    }
}