<?php

namespace App\Tools;

class Curls
{
    /**
     * curl packaging
     * @param $url
     * @param string $method
     * @param string $data
     * @param array $headers
     * @param array $proxy
     * @return bool|string
     */
    public static function send($url, $method='GET', $data='', $headers=[], $proxy=[])
    {
        $method = strtoupper($method);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        //set body
        if ($method != 'GET') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        }

        //set proxy
        if (array_key_exists('ip', $proxy) && $proxy['ip']) {
            self::setProxy($ch, $proxy);
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }

    /**
     * set curl proxy
     * @param $ch
     * @param array $proxy
     */
    private static function setProxy($ch, array $proxy)
    {
        /** set proxy ip */
        curl_setopt($ch, CURLOPT_PROXY, $proxy['ip']);

        /** set proxy port */
        $port = $proxy['port'] ?? 3128;
        curl_setopt($ch, CURLOPT_PROXYPORT, $port);

        /** set username and password */
        if (array_key_exists('username', $proxy)
            && $proxy['username']
            && array_key_exists('password', $proxy)
            && $proxy['password']
        ) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['username'] . ':' . $proxy['password']);
        }
    }
}
