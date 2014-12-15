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

$baseDir = realpath(dirname(__FILE__) . '/../') . '/';

require_once $baseDir . '/vendor/autoload.php';

use AFiestas\ProtectFont\Application;
use AFiestas\ProtectFont\FontSettings;

$settings = array(
    'baseDir' => $baseDir,
    'fontPath' => $baseDir . '/superSecretFolder/'
);

$fontConfig = new FontSettings($baseDir . 'font-settings.json');
$application = new Application($settings, $fontConfig);
$application->run($_GET, $_SERVER);
