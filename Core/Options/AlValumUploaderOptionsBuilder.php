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

namespace AlphaLemon\AlValumUploaderBundle\Core\Options;

use AlphaLemon\AlValumUploaderBundle\Core\Options\AlOptionsBuilder;

/**
 * Description of AlValumUploaderOptionsBuilder
 *
 * @author AlphaLemon
 */
class AlValumUploaderOptionsBuilder extends AlOptionsBuilder
{
    public function configure(AlOptionsMapper $mapper)
    {
        $mapper->add('panel_title', 'valum.panel_title');
        $mapper->add('panel_info', 'valum.panel_info');
        $mapper->add('id', 'valum.id', 'al_valum_uploader');
        $mapper->add('upload_action', 'valum.upload_action', 'al_uploadFile');
        $mapper->add('allowed_extensions', 'valum.allowed_extensions', "jpg','jpeg','png','gif','bmp'");
        $mapper->add('params', 'valum.params');
        $mapper->add('size_limit', 'valum.size_limit', '2500000');
        $mapper->add('min_size_limit', 'valum.min_size_limit', '0');
        $mapper->add('onSubmit', 'valum.onSubmit');
        $mapper->add('onProgress', 'valum.onProgress');
        $mapper->add('onComplete', 'valum.onComplete');
        $mapper->add('onCancel', 'valum.onCancel');
    }
}