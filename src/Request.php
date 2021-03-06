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

/**
* Translates an HTTP request into a DAO
*/
class Request
{
    private $query = null;
    private $fontNameParser;

    public function __construct($query, $fontNameParser = null)
    {
        $this->query = $query;
        $this->fontNameParser = $fontNameParser ? $fontNameParser : new FontNameParser();
    }

    public function getFont()
    {
        $info = $this->fontNameParser->parse($this->query['font']);
        $info['originalName'] = $this->query['font'];
        return $info;
    }
}