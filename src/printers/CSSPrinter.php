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

require_once dirname(__FILE__) . '/../IPrinter.php';

class CSSPRinter implements iPrinter
{
    public function printFont($path)
    {
        $pathInfo = pathinfo($path);
        $licensePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.license';
        $license = file_get_contents($licensePath);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path);
        finfo_close($finfo);

        $fontBase = base64_encode(file_get_contents($path));

        $template = file_get_contents(dirname(__FILE__) . '/css.template');

        $template = str_replace('{license}', $license, $template);
        $template = str_replace('{filename}', $pathInfo['filename'], $template);
        $template = str_replace('{mime}', $mime, $template);
        $template = str_replace('{base64}', $fontBase, $template);

        echo $template;
    }
}