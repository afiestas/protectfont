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

$baseDir = dirname(dirname(__FILE__));
require_once  $baseDir . '/vendor/autoload.php';

use AFiestas\ProtectFont\DomainMatcher;

class DomainMatcherTest extends PHPUnit_Framework_TestCase
{

    /**
    * @dataProvider matchTrueProvider
    */
    public function testMatchTrue($domain, $domainPatterns)
    {
        $sut = new DomainMatcher();
        $result = $sut->match($domain, $domainPatterns);
        $this->assertTrue($result);
    }

    public function matchTrueProvider()
    {
        $domainPatterns = array('*.afiestas.*','*.org', 'www.kde.org','*e-lena.es');
        return array(
            array("www.afiestas.*", $domainPatterns),
            array('some-org.org', $domainPatterns),
            array('www.kde.org', $domainPatterns),
            array('e-lena.es', $domainPatterns)
        );
    }

    /**
    * @dataProvider matchFalseProvider
    */
    public function testMatchFalse($domain, $domainList)
    {
        $sut = new DomainMatcher();
        $result = $sut->match($domain, $domainList);
        $this->assertFalse($result);
    }

    public function matchFalseProvider()
    {
        $domainPatterns = array('only-me.org');
        return array(
            array("afiestas.org", $domainPatterns),
            array("kde.org", $domainPatterns),
        );
    }

}