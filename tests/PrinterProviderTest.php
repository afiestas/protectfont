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

use AFiestas\ProtectFont\EmptyPrinter;
use AFiestas\ProtectFont\PrinterProvider;

class PrinterProviderTest extends PHPUnit_Framework_TestCase
{
    private $sut;

    public function setUp()
    {
        $this->sut = new PrinterProvider();
    }

    public function testLoadPrinter()
    {
        $result = $this->sut->loadPrinter('foo');
        $this->assertFalse($result, 'Should return false since file does not exists');

        $result = $this->sut->loadPrinter('../../protectfont');
        $this->assertFalse($result, 'Should return false because realpath is outside basedir');

        $printer = $this->sut->loadPrinter('empty');
        $this->assertInstanceOf('AFiestas\ProtectFont\EmptyPrinter', $printer, 'An EmptyPrinter should be returned');
    }
}