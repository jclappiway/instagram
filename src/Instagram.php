<?php

/*
 * This file is part of Instagram.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vinkla\Instagram;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * This is the instagram class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class Instagram
{
    /**
     * The guzzle http client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Create a new instagram instance.
     *
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(ClientInterface $client = null)
    {
        if (is_null($client)) {
            $client = new Client();
        }
        $this->client = $client;
    }

    /**
     * Fetch the media items.
     *
     * @param string $user
     *
     * @throws \Vinkla\Instagram\InstagramException
     *
     * @return array
     */
    public function get($user)
    {
        try {
            $url = sprintf('https://www.instagram.com/%s/media', $user);

            $response = $this->client->get($url);
            $body     = $response->getBody();
            $content  = $body->getContents();

            return json_decode($content, true)['items'];
        } catch (RequestException $e) {
            throw new InstagramException(sprintf('The user [%s] was not found.', $user));
        }
    }
}
