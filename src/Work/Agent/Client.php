<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Work\Agent;

use PowerWeChat\Kernel\BaseClient;

/**
 * This is WeWork Agent Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get agent.
     *
     * @param int $agentId
     *
     * @return mixed
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function get(int $agentId)
    {
        $params = [
            'agentid' => $agentId,
        ];

        return $this->httpGet('cgi-bin/agent/get', $params);
    }

    /**
     * Set agent.
     *
     * @param int   $agentId
     * @param array $attributes
     *
     * @return mixed
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function set(int $agentId, array $attributes)
    {
        return $this->httpPostJson('cgi-bin/agent/set', array_merge(['agentid' => $agentId], $attributes));
    }

    /**
     * Get agent list.
     *
     * @return mixed
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function list()
    {
        return $this->httpGet('cgi-bin/agent/list');
    }
}