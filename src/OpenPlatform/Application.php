<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OpenPlatform;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\MiniProgram\Encryptor;
use PowerWeChat\OpenPlatform\Authorizer\Auth\AccessToken;
use PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Application as MiniProgram;
use PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Auth\Client;
use PowerWeChat\OpenPlatform\Authorizer\OfficialAccount\Application as OfficialAccount;
use PowerWeChat\OpenPlatform\Authorizer\OfficialAccount\OAuth\ComponentDelegate;
use PowerWeChat\OpenPlatform\Authorizer\Server\Guard;

/**
 * Class Application.
 *
 * @property \PowerWeChat\OpenPlatform\Server\Guard        $server
 * @property \PowerWeChat\OpenPlatform\Auth\AccessToken    $access_token
 * @property \PowerWeChat\OpenPlatform\CodeTemplate\Client $code_template
 *
 * @method mixed handleAuthorize(string $authCode = null)
 * @method mixed getAuthorizer(string $appId)
 * @method mixed getAuthorizerOption(string $appId, string $name)
 * @method mixed setAuthorizerOption(string $appId, string $name, string $value)
 * @method mixed getAuthorizers(int $offset = 0, int $count = 500)
 * @method mixed createPreAuthorizationCode()
 * @method mixed clearQuota()
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Server\ServiceProvider::class,
        CodeTemplate\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        'http' => [
            'timeout' => 5.0,
            'base_uri' => 'https://api.weixin.qq.com/',
        ],
    ];

    /**
     * Creates the officialAccount application.
     *
     * @param string                                                    $appId
     * @param string|null                                               $refreshToken
     * @param \PowerWeChat\OpenPlatform\Authorizer\Auth\AccessToken|null $accessToken
     *
     * @return \PowerWeChat\OpenPlatform\Authorizer\OfficialAccount\Application
     */
    public function officialAccount(string $appId, string $refreshToken = null, AccessToken $accessToken = null): OfficialAccount
    {
        $application = new OfficialAccount($this->getAuthorizerConfig($appId, $refreshToken), $this->getReplaceServices($accessToken) + [
            'encryptor' => $this['encryptor'],
        ]);

        $application->extend('oauth', function ($socialite) {
            /* @var \Overtrue\Socialite\Providers\WeChatProvider $socialite */
            return $socialite->component(new ComponentDelegate($this));
        });

        return $application;
    }

    /**
     * Creates the miniProgram application.
     *
     * @param string                                                    $appId
     * @param string|null                                               $refreshToken
     * @param \PowerWeChat\OpenPlatform\Authorizer\Auth\AccessToken|null $accessToken
     *
     * @return \PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Application
     */
    public function miniProgram(string $appId, string $refreshToken = null, AccessToken $accessToken = null): MiniProgram
    {
        return new MiniProgram($this->getAuthorizerConfig($appId, $refreshToken), $this->getReplaceServices($accessToken) + [
            'encryptor' => function () {
                return new Encryptor($this['config']['app_id'], $this['config']['token'], $this['config']['aes_key']);
            },

            'auth' => function ($app) {
                return new Client($app, $this);
            },
        ]);
    }

    /**
     * Return the pre-authorization login page url.
     *
     * @param string      $callbackUrl
     * @param string|null $authCode
     *
     * @return string
     */
    public function getPreAuthorizationUrl(string $callbackUrl, string $authCode = null): string
    {
        $queries = [
            'component_appid' => $this['config']['app_id'],
            'pre_auth_code' => $authCode ?: $this->createPreAuthorizationCode()['pre_auth_code'],
            'redirect_uri' => $callbackUrl,
        ];

        return 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?'.http_build_query($queries);
    }

    /**
     * 开放平台添加http实例配置
     * @param string      $appId
     * @param string|null $refreshToken
     *
     * @return array
     */
    protected function getAuthorizerConfig(string $appId, string $refreshToken = null): array
    {
        $config = [
            'debug' => $this['config']->get('debug', false),
            'response_type' => $this['config']->get('response_type'),
            'log' => $this['config']->get('log', []),
            'app_id' => $appId,
            'refresh_token' => $refreshToken,
        ];

        $http_config = $this['config']->get('http', []);

        if($http_config) {
            $config['http'] = $http_config;
        }

        return $config;
    }

    /**
     * @param \PowerWeChat\OpenPlatform\Authorizer\Auth\AccessToken|null $accessToken
     *
     * @return array
     */
    protected function getReplaceServices(AccessToken $accessToken = null): array
    {
        return [
            'access_token' => $accessToken ?: function ($app) {
                return new AccessToken($app, $this);
            },

            'server' => function ($app) {
                return new Guard($app);
            },
        ];
    }

    /**
     * Handle dynamic calls.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this['base'], $method], $args);
    }
}
