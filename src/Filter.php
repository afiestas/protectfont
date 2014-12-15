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

class Filter
{
    private $fontSettings;
    private $domainMatcher;
    private $lastFiltered = '';

    public function __construct($fontSettings, $domainMatcher = null)
    {
        $this->fontSettings = $fontSettings;
        $this->domainMatcher = $domainMatcher ? $domainMatcher : new DomainMatcher();
    }

    public function lastFiltered()
    {
        return $this->lastFiltered;
    }

    public function filterAccessByFontExists($fontName)
    {
        if (!$this->fontSettings->fontExists($fontName)) {
            $this->lastFiltered = 'font does not exists';
            return false;
        }
        return true;
    }

    public function filterAccessByRefererExists($serverRequest)
    {
        if (array_key_exists('HTTP_REFERER', $serverRequest) && empty($serverRequest['HTTP_REFERER'])) {
            $this->lastFiltered = 'no http referer';
            return false;
        }
        return true;
    }

    public function filterAccessByDomains($fontName, $serverRequest)
    {
        $domains = $this->fontSettings->getFontDomains($fontName);
        if (empty($domains)) {
            $this->lastFiltered = 'No domains for this font';
            return false;
        }

        if (!$this->domainMatcher->match($serverRequest['HTTP_REFERER'], $domains)) {
            $this->lastFiltered = 'Domain not whitelisted';
            return false;
        }
        return true;
    }

    public function filterAccess($fontName, $serverRequest)
    {
        if (!$this->filterAccessByRefererExists($serverRequest) ||
            !$this->filterAccessByFontExists($fontName) ||
            !$this->filterAccessByDomains($fontName, $serverRequest)) {
            return false;
        }

        $this->lastFiltered = 'ok';
        return true;
    }
}
