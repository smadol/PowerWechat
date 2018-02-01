<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OfficialAccount;

use PowerWeChat\BasicService;
use PowerWeChat\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \PowerWeChat\BasicService\Media\Client               $media
 * @property \PowerWeChat\BasicService\Url\Client                 $url
 * @property \PowerWeChat\BasicService\QrCode\Client              $qrcode
 * @property \PowerWeChat\BasicService\Jssdk\Client               $jssdk
 * @property \PowerWeChat\OfficialAccount\Auth\AccessToken        $access_token
 * @property \PowerWeChat\OfficialAccount\Server\Guard            $server
 * @property \PowerWeChat\OfficialAccount\User\UserClient         $user
 * @property \PowerWeChat\OfficialAccount\User\TagClient          $user_tag
 * @property \PowerWeChat\OfficialAccount\Menu\Client             $menu
 * @property \PowerWeChat\OfficialAccount\TemplateMessage\Client  $template_message
 * @property \PowerWeChat\OfficialAccount\Material\Client         $material
 * @property \PowerWeChat\OfficialAccount\CustomerService\Client  $customer_service
 * @property \PowerWeChat\OfficialAccount\Semantic\Client         $semantic
 * @property \PowerWeChat\OfficialAccount\DataCube\Client         $data_cube
 * @property \PowerWeChat\OfficialAccount\AutoReply\Client        $auto_reply
 * @property \PowerWeChat\OfficialAccount\Broadcasting\Client     $broadcasting
 * @property \PowerWeChat\OfficialAccount\Card\Card               $card
 * @property \PowerWeChat\OfficialAccount\Device\Client           $device
 * @property \PowerWeChat\OfficialAccount\ShakeAround\ShakeAround $shake_around
 * @property \PowerWeChat\OfficialAccount\Base\Client             $base
 * @property \Overtrue\Socialite\Providers\WeChatProvider        $oauth
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Server\ServiceProvider::class,
        User\ServiceProvider::class,
        OAuth\ServiceProvider::class,
        Menu\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        Material\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        Semantic\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        POI\ServiceProvider::class,
        AutoReply\ServiceProvider::class,
        Broadcasting\ServiceProvider::class,
        Card\ServiceProvider::class,
        Device\ServiceProvider::class,
        ShakeAround\ServiceProvider::class,
        Comment\ServiceProvider::class,
        Base\ServiceProvider::class,
        // Base services
        BasicService\QrCode\ServiceProvider::class,
        BasicService\Media\ServiceProvider::class,
        BasicService\Url\ServiceProvider::class,
        BasicService\Jssdk\ServiceProvider::class,
    ];
}