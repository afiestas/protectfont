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
 *  You should have received a copy of the GNU General Public License                *
 *  along with this program; if not, write to the Free Software                      *
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA   *
 *************************************************************************************/

namespace AFiestas\ProtectFont\Tests;

use AFiestas\ProtectFont\Request;
use AFiestas\ProtectFont\FontNameParser;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private $fontName = 'arial-emojis-css';

    public function testGetFont()
    {

        $fontNameParser = $this->getMock('FontNameParser', array('parse'));
        $fontNameParser->expects($this->once())
                        ->method('parse')
                        ->with($this->equalTo($this->fontName));

        $get = array("font" => $this->fontName);
        $sut = new Request($get, $fontNameParser);

        $font = $sut->getFont();
        $this->assertTrue(is_array($font));
    }

    public function testGetFontOriginalName()
    {
        $get = array("font" => $this->fontName);
        $sut = new Request($get);

        $font = $sut->getFont();
        $this->assertEquals($font["originalName"], $this->fontName);
    }
}