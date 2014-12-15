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

use AFiestas\ProtectFont\Filter;
use AFiestas\ProtectFont\FontSettings;
use AFiestas\ProtectFont\DomainMatcher;

class FilterTest extends PHPUnit_Framework_TestCase
{

    private $sut;
    private $fontSettings;
    private $domainMatcher;
    private static $settingsFile;

    public static function setUpBeforeClass()
    {
        self::$settingsFile = file_get_contents(dirname(__FILE__) . '/font-settings.json');
    }

    public function setUp()
    {
        $this->fontSettings = $this->getMock('FontSettings', array('fontExists', 'getFontDomains'));
        $this->domainMatcher = $this->getMock('DomainMatcher', array('match'));

        $this->sut = new Filter($this->fontSettings, $this->domainMatcher);
    }

    public function testFilterAccessByFontExists()
    {
        $fontName = 'deny-access-not-found';

        $this->fontSettings->expects($this->once())
                            ->method('fontExists')
                            ->with($fontName)
                            ->willReturn(false);
        $result = $this->sut->filterAccessByFontExists($fontName);

        $this->assertFalse($result, 'Font access should be denied because font does not exists in the config');
    }

    public function testFilterAccessByRefererExists()
    {
        $_SERVER['HTTP_REFERER'] = '';
        $result = $this->sut->filterAccessByRefererExists();
        $this->assertFalse($result, 'Access should be denied because there is no http referer');
    }

    public function testFilterAccessByDomains()
    {
        $fontName = 'not-really-important';

        $domainList = array('foo.bar');
        $this->fontSettings->expects($this->once())
                            ->method('getFontDomains')
                            ->willReturn($domainList);

        $domain = 'afiestas.org';
        $_SERVER['HTTP_REFERER'] = $domain;
        $this->domainMatcher->expects($this->once())
                            ->method('match')
                            ->with($domain, $domainList);


        $result = $this->sut->filterAccessByDomains($fontName);
        $this->assertFalse($result, 'Access should be denied because the font has no domains');

        
    }
}