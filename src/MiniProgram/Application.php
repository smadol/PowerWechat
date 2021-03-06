<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\MiniProgram;

use PowerWeChat\BasicService;
use PowerWeChat\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \PowerWeChat\MiniProgram\Auth\AccessToken            $access_token
 * @property \PowerWeChat\MiniProgram\DataCube\Client             $data_cube
 * @property \PowerWeChat\MiniProgram\AppCode\Client              $app_code
 * @property \PowerWeChat\MiniProgram\Auth\Client                 $auth
 * @property \PowerWeChat\OfficialAccount\Server\Guard            $server
 * @property \PowerWeChat\MiniProgram\Encryptor                   $encryptor
 * @property \PowerWeChat\MiniProgram\TemplateMessage\Client      $template_message
 * @property \PowerWeChat\OfficialAccount\CustomerService\Client  $customer_service
 * @property \PowerWeChat\BasicService\Media\Client               $media
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Server\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        // Base services
        BasicService\Media\ServiceProvider::class,
    ];
}
