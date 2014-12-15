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

use AFiestas\ProtectFont\FontLocator;

class FontLocatorTest extends \PHPUnit_Framework_TestCase
{
    private $fontName = 'arial-latin-base64';

    public function testGetFontPath()
    {
        $fontSettings = $this->getMock('FontSettings', array('getFontPath'));
        $fontSettings->expects($this->once())
                        ->method('getFontPath')
                        ->with($this->equalTo($this->fontName))
                        ->willReturn('arialLaten.txt');

        $settings = array(
            'baseDir' => dirname(__FILE__),
            'fontPath' => dirname(__FILE__)
        );

        $sut = new FontLocator($settings, $fontSettings);

        $font = $sut->getFontPath($this->fontName);
        $this->assertEquals($font, $settings['fontPath'] . '/arialLaten.txt');
    }
}