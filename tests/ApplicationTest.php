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


namespace AFiestas\ProtectFont\Tests;

use AFiestas\ProtectFont\Application;
use AFiestas\ProtectFont\FontSettings;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    private $sut;

    public function setUp()
    {
        $baseDir = dirname(__FILE__);

        $settings = array(
            'baseDir' => $baseDir,
            'fontPath' => $baseDir
        );

        $fontSettings = new FontSettings($baseDir . '/font-settings.json');
        $this->sut = new Application($settings, $fontSettings);
    }

    public function testApplicationRunNotExisting()
    {
        $request = array('font' => 'not existing');
        $server = array();
        $r = $this->sut->run($request, $server);
        $this->expectOutputString(':)');
        $this->assertEquals('font does not exists', $r);
    }

    public function testApplicationRunNoReferer()
    {
        $request = array('font' => 'arial-laten-raw');
        $server = array();
        $r = $this->sut->run($request, $server);
        $this->expectOutputString(':)');
        $this->assertEquals('font does not exists', $r);
    }

    public function testApplicationDomainNotWhitelist()
    {
        $request = array('font' => 'arial-laten-raw');
        $server = array('HTTP_REFERER' => 'foo.bar');
        $r = $this->sut->run($request, $server);
        $this->expectOutputString(':)');
        $this->assertEquals('font does not exists', $r);
    }

    /**
     * @runInSeparateProcess
     */
    public function testApplication()
    {
        $request = array('font' => 'arial-latin-raw');
        $server = array('HTTP_REFERER' => 'test.afiestas.org');
        $r = $this->sut->run($request, $server);
        $this->expectOutputString('fake font');
        $this->assertEquals(null, $r);
    }
}