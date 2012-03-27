<?php

/**
 * WDS GROUP
 *
 * @name        ProfilesController.php
 * @category    
 * @package     package_name
 * @author      Thuy Dinh Xuan <thuydx@wds.vn>
 * @copyright   Copyright (c)2008-2010 WDS GROUP. All rights reserved
 * @license     http://wds.vn/license/     WDS Software License
 * @version     $1.0.0$
 * 11:48:38 AM - Mar 26, 2012
 *
 * LICENSE
 *
 * This source file is copyrighted by WDS, full details in LICENSE.txt.
 * It is also available through the Internet at this URL:
 * http://wds.vn/license/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the Internet, please send an email
 * to license@wds.vn so we can send you a copy immediately.
 *
 */

namespace User\Controller;

use Zend\Soap\Client\Local;

use Zend\Cache\Utils;
use Zend\Locale\Locale;
use Zend\Translator\Translator;
use Zend\Mvc\Controller\ActionController;

class ProfilesController extends ActionController
{
    public function indexAction()
    {
        $adapter = new Translator(
            array(
                'adapter' => 'arrayAdapter',
                'content' => array('hello' => 'xin chào ','sex' => 'xxx'),
                'locale'  => 'vi'
            )
        );
        
        return array('adapter' => $adapter);
    
//          die();
//         $diskCapacity = array();
//         foreach (Utils::getDiskCapacity(__DIR__) as $key => $dc)
//         {
//             $diskCapacity[$key] = Utils::bytesFromString($dc.'b');
//         }
//         $phpMemory = array();
//         foreach (Utils::getPhpMemoryCapacity() as $key => $pm)
//         {
//             $phpMemory[$key] = Utils::bytesFromString($pm.'b');
//         }
//         $systemMemory = array();
//         foreach(Utils::getSystemMemoryCapacity() as $key => $sm)
//         {
//             $systemMemory[$key] = Utils::bytesFromString($sm .'b');
//         }
//         return array('diskCapacity' => $diskCapacity, 'phpMemory' => $phpMemory,'sysMemory' => $systemMemory);
    }
}
