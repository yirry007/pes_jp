<?php

namespace App\Tools;

class Image {
    /**
     * save image from internet
     * @param $data
     * @param $path
     * @return bool|string
     */
    public static function saveFromUrl($data, $path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);  //需要response header
        curl_setopt($ch, CURLOPT_NOBODY, FALSE);  //需要response body
        $response = curl_exec($ch);

        $body = '';//image blob
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE); //头信息size
            $body = substr($response, $headerSize);
        }
        curl_close($ch);

        if (!$body) return false;

        return file_put_contents($path, $body);
    }
}
