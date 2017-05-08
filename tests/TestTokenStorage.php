<?php

/**
 * Copyright (c) 2016, 2017 François Kooman <fkooman@tuxed.net>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace fkooman\OAuth\Client\Tests;

use fkooman\OAuth\Client\AccessToken;
use fkooman\OAuth\Client\TokenStorageInterface;

class TestTokenStorage extends TestSession implements TokenStorageInterface
{
    /**
     * @param string $userId
     * @param string $providerId
     * @param string $requestScope
     *
     * @return AccessToken|false
     */
    public function getAccessToken($userId, $providerId, $requestScope)
    {
        if (!$this->has(sprintf('_oauth2_token_%s_%s_%s', $userId, $providerId, $requestScope))) {
            return false;
        }

        return $this->get(sprintf('_oauth2_token_%s_%s_%s', $userId, $providerId, $requestScope));
    }

    /**
     * @param string      $userId
     * @param string      $providerId
     * @param AccessToken $accessToken
     */
    public function setAccessToken($userId, $providerId, AccessToken $accessToken)
    {
        $this->set(sprintf('_oauth2_token_%s_%s_%s', $userId, $providerId, $accessToken->getScope()), $accessToken);
    }

    /**
     * @param string      $userId
     * @param string      $providerId
     * @param AccessToken $accessToken
     */
    public function deleteAccessToken($userId, $providerId, AccessToken $accessToken)
    {
        if ($this->has(sprintf('_oauth2_token_%s_%s_%s', $userId, $providerId, $accessToken->getScope()))) {
            $this->del(sprintf('_oauth2_token_%s_%s_%s', $userId, $providerId, $accessToken->getScope()));
        }
    }
}
