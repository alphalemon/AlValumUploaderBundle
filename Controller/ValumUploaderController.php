<?php
/*
 * This file is part of the AlValumUploaderBundle and it is distributed
 * under the MIT License. To use this bundle you must leave
 * intact this copyright notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://alphalemon.com
 * 
 * @license    MIT License
 */

namespace AlphaLemon\AlValumUploaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AlphaLemon\AlValumUploaderBundle\Core\Uploader\qqFileUploader;
use AlphaLemon\AlValumUploaderBundle\Core\Options\AlValumUploaderOptionsBuilder;


class ValumUploaderController extends Controller
{
    public function showAction()
    {
        $valumOptionsBuilder = new AlValumUploaderOptionsBuilder($this->container);
        $valumOptionsBuilder->build();
        
        return $this->render('AlValumUploaderBundle:Valum:show.html.twig', array('options' => $valumOptionsBuilder->getOptions()));
    }

    public function uploadAction()
    {
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array();

        // max file size in bytes
        $sizeLimit = 6 * 1024 * 1024;
        
        $request = $this->container->get('request');
        $translator = $this->container->get('translator');

        $folder = trim(urldecode($request->get('folder')));
        if(substr($folder, strlen($folder) - 1, 1) != "/") $folder .= "/";
        
        if(!is_dir($folder))
        {
            $response = new Response();
            $response->setStatusCode('404');
            $response->setContent($translator->trans('The folder %folder% does not exists. Check your valum\'s configuration file', array('folder' => $folder)));
            
            return $response;
        }

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder, true);
        
        $response = new Response();
        $response->setContent(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
        return $response;
    }
}


