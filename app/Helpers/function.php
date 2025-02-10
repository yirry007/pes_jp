<?php

/**
 * uniform host url
 * @param $path
 * @return string
 */
function _url_($path): string
{
    return url($path);
    //return secure_url($path);
}

/**
 * determine array has effective value
 * @param string $key
 * @param array $array
 * @return bool
 */
function array_member(string $key, array $array): bool
{
    if (array_key_exists($key, $array) && $array[$key] !== null && $array[$key] !== '') {
        return true;
    } else {
        return false;
    }
}

/**
 * determine array has the key
 * @param string $key
 * @param array $array
 * @param bool $is_num
 * @return string
 */
function array_val(string $key, array $array, bool $is_num=false): string | null
{
    if ($is_num)
        return array_key_exists($key, $array) ? $array[$key] : '0';
    else
        return array_key_exists($key, $array) ? $array[$key] : '';
}

/**
 * xml -> array
 * @param string $xml
 * @return mixed
 */
function xmlToArray(string $xml): mixed
{
    $xml_parser = xml_parser_create();
    if (!xml_parse($xml_parser,$xml,true)) {
        return [
            'code' => 'E6011',
            'message' => 'XML data format error. ' . (string)$xml,
        ];
    }

    $xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    $jsonString = json_encode($xmlObj);
    return json_decode($jsonString, true);
}

/**
 * array -> xml
 * @param $arr
 * @param string $root
 * @param bool $dom
 * @param bool $item
 * @return false|string
 * @throws DOMException
 */
function arrayToXml($arr, string $root='root', bool $dom=false, bool $item=false): bool|string
{
    if (!$dom) {
        $dom = new DOMDocument("1.0");
    }
    if (!$item) {
        $item = $dom->createElement($root);
        $dom->appendChild($item);
    }
    foreach ($arr as $key => $val) {
        $itemx = $dom->createElement(is_string($key) ? $key : "item");
        $item->appendChild($itemx);
        if (!is_array($val)) {
            $text = $dom->createTextNode($val);
            $itemx->appendChild($text);
        } else {
            arrayToXml($val, $key, $dom, $itemx);
        }
    }
    return $dom->saveXML();
}

/**
 * encrypt string
 * @param string $data
 * @param string $key
 * @return string
 */
function enc(string $data, string $key = 'encrypt'): string
{
    $key = md5($key);
    $x = 0;
    $len = strlen($data);
    $l = strlen($key);
    $char = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) {
            $x = 0;
        }
        $char .= $key[$x];
        $x++;
    }
    $str = '';
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord($data[$i]) + (ord($char[$i])) % 256);
    }
    return base64_encode($str);
}

/**
 * decrypt string
 * @param string $data
 * @param string $key
 * @return string
 */
function dec(string $data, string $key = 'encrypt'): string
{
    $key = md5($key);
    $x = 0;
    $data = base64_decode($data);
    $len = strlen($data);
    $l = strlen($key);
    $char = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) {
            $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    $str = '';
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}
