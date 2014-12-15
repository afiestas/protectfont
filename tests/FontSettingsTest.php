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

use AFiestas\ProtectFont\FontSettings;

class FontSettingsTest extends PHPUnit_Framework_TestCase
{
    private $sut;
    private static $settingsFile;

    public static function setUpBeforeClass()
    {
        self::$settingsFile = dirname(__FILE__) . '/font-settings.json';
    }

    public function setUp()
    {
        $this->sut = new FontSettings(self::$settingsFile);
    }

    public function testFontExistsSuccess()
    {
        $existingFont = 'arial-latin-base64';
        $result = $this->sut->fontExists($existingFont);

        $this->assertTrue($result);
    }

    public function testFontExistsFalse()
    {
        $notExistingFont = 'rolf-foo-bar';
        $result = $this->sut->fontExists($notExistingFont);

        $this->assertFalse($result);
    }

    public function testGetFontDomains()
    {
        $existingFont = 'arial-latin-base64';
        $result = $this->sut->getFontDomains($existingFont);

        $this->assertEquals($result, array('*.afiestas.*'));
    }

    public function testFontPath()
    {
        $existingFont = 'arial-latin-base64';
        $result = $this->sut->getFontPath($existingFont);

        $this->assertEquals($result, 'arialLaten.txt');
    }
}