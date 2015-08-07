<?php
namespace Is;

/**
 * Class Is
 * @package Is
 */
class Is
{
    const VERSION = '0.0.5';

    /**
     * @param $check_string
     * @return bool
     */
    private static function _check_sapi_name($check_string)
    {
        return php_sapi_name() === $check_string;
    }

    /**
     * @return bool
     */
    public static function apache()
    {
        return self::_check_server_software("Apache");
    }

    /**
     * @param $soft_name
     * @return bool
     */
    private static function _check_server_software($soft_name)
    {
        if (isset($_SERVER['SERVER_SOFTWARE'])) {
            return self::str_include($_SERVER['SERVER_SOFTWARE'], $soft_name);
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function ssl()
    {
        if (isset($_SERVER['HTTPS']) && isset($_SERVER['HTTP_HTTPS'])) {
            return $_SERVER['HTTPS'] === 'on' || $_SERVER['HTTP_HTTPS'] === '1';
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function localhost()
    {
        if (!isset($_SERVER['SERVER_NAME'])) {
            return false;
        }

        if ($_SERVER['SERVER_NAME'] === '127.0.0.1' || $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '0.0.0.0') {
            return true;
        }

        return false;
    }

    /**
     * @param $host string
     * @return bool
     */
    public static function host($host)
    {
        if (!isset($_SERVER['SERVER_NAME'])) {
            return false;
        }

        if ($host === "localhost" || $host === '127.0.0.1' || $host === '0.0.0.0') {
            return true;
        }

        if ($_SERVER['SERVER_NAME'] === $host) {
            return true;
        }

        return false;
    }

    /**
     * @param $ip string
     * @return bool
     */
    public static function host_ip($ip)
    {
        if (!isset($_SERVER['SERVER_ADDR'])) {
            return false;
        }

        return $_SERVER['SERVER_ADDR'] === $ip;
    }


    /**
     * @return bool
     */
    public static function build_in_server()
    {
        return self::_check_server_software("Development");
    }

    /**
     * @return bool
     */
    public static function cli()
    {
        return self::_check_sapi_name('cli');
    }

    /**
     * @return bool
     */
    public static function ios()
    {
        return self::_check_browser("iPhone") || self::_check_browser("iPad") || self::_check_browser("iPod");
    }

    /**
     * @return bool
     */
    public static function android()
    {
        return self::_check_browser("Android");
    }

    public static function phone()
    {
        return self::mobile();
    }

    /**
     * @return bool
     */
    public static function mobile()
    {
        $mobile_lists = [
            'ipod',
            'iphone',
            'android',
            'firefox',
            'blackberry',
        ];

        foreach ($mobile_lists as $mobile) {
            if ($mobile === 'firefox' || $mobile === 'android') {
                $result = self::_check_mobile_agent($mobile, 'mobile');
            } else {
                $result = self::_check_mobile_agent($mobile);
            }

            if ($result) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function tablet()
    {
        $ua = mb_strtolower($_SERVER['HTTP_USER_AGENT']);

        if (self::str_include($ua, 'android') && !self::str_include($ua, 'mobile')) {
            return true;
        } elseif (self::str_include($ua, 'firefox') && self::str_include($ua, 'tablet')) {
            return true;
        } elseif (self::str_include($ua, 'windows') && self::str_include($ua, 'touch')) {
            return true;
        } elseif (self::str_include($ua, 'kindle') || self::str_include($ua, 'silk')) {
            return true;
        } elseif (self::str_include($ua, 'ipad')) {
            return true;
        } elseif (self::str_include($ua, 'playbook')) {
            return true;
        }

        return false;
    }

    /**
     * @param $params
     */
    private static function _check_mobile_agent($params, $key = null)
    {
        $ua = mb_strtolower($_SERVER['HTTP_USER_AGENT']);
        if ($key) {
            return self::str_include($ua, $params) && self::str_include($ua, $key);
        } else {
            return self::str_include($ua, $params);
        }
    }

    /**
     * @return bool
     */
    public static function safari()
    {
        //最初にChromeが存在しないかチェックする
        return !self::_check_browser("Chrome") && self::_check_browser("Safari");
    }

    /**
     * @return bool
     */
    public static function chrome()
    {
        return self::_check_browser("Chrome");
    }

    /**
     * @return bool
     */
    public static function firefox()
    {
        return self::_check_browser("Firefox");
    }

    /**
     * @param $preg_string
     * @return bool
     */
    private static function _check_browser($preg_string)
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return self::str_include($_SERVER['HTTP_USER_AGENT'], $preg_string);
        }

        return false;
    }

    /**
     * @param $version int
     * @return bool
     */
    public static function ie($version = null)
    {
        if ($version) {
            $version = strval($version) . '.0';

            return self::_check_browser("MSIE") && self::str_include($_SERVER['HTTP_USER_AGENT'], $version);
        } else {
            return self::_check_browser("MSIE");
        }
    }

    /**
     * @return bool
     */
    public static function opera()
    {
        return self::_check_browser("Opera");
    }

    /**
     * @param $lang
     * @return bool
     */
    public static function lang($lang)
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return false;
        }

        $server_langs = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($server_langs as $server_lang) {
            if (preg_match('/^' . $lang . '/i', $server_lang)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $ex
     * @return bool
     */
    public static function load_extension($ex)
    {
        $extenstions = get_loaded_extensions();

        foreach ($extenstions as $extension) {
            if ($extension === $ex) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $check_type
     * @return bool
     */
    private static function _check_http_method($check_type)
    {
        return $_SERVER['REQUEST_METHOD'] === $check_type;
    }

    /**
     * @return bool
     */
    public static function request_get()
    {
        return self::_check_http_method('GET');
    }

    /**
     * @return bool
     */
    public static function request_post()
    {
        return self::_check_http_method('POST');
    }

    /**
     * @return bool
     */
    public static function request_delete()
    {
        return self::_check_http_method('DELETE');
    }

    /**
     * @return bool
     */
    public static function request_put()
    {
        return self::_check_http_method('PUT');
    }

    /**
     * @return bool
     */
    public static function request_patch()
    {
        return self::_check_http_method('PATCH');
    }

    /**
     * @todo filter_varで簡易的に実装しているが、日本のよくわからないメールアドレスについては対応してないので、そのうち頑張る。
     * @param $mail
     * @return bool
     */
    public static function email($mail)
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @param $url
     * @return bool
     */
    public static function url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * @param $ip
     * @return bool
     */
    public static function ip($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * @param $ip
     * @return bool
     */
    public static function ipv4($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * @param $ip
     * @return bool
     */
    public static function ipv6($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * @param $num
     * @return bool
     */
    public static function creditcard($num)
    {
        if (preg_match("/^(?:(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/",
            $num)) {
            return true;
        }

        return false;
    }

    /**
     *
     * URLが取得できない場合はfile_get_contentsにて普通に例外を投げます。
     *
     * @param $uri
     * @param $http_status_code
     * @return bool
     */
    public static function http_status_code($uri, $http_status_code)
    {
        $context = stream_context_create([
            'http' => ['ignore_errors' => true]
        ]);

        file_get_contents($uri, null, $context, 0, 1);
        preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
        $status_code = $matches[1];

        return $status_code == $http_status_code;
    }

    /**
     * @param $str
     * @param $sub_str
     * @return bool
     */
    public static function str_include($str, $sub_str)
    {
        return strpos($str, $sub_str) !== false;
    }

    /**
     * @param $str
     * @param $sub_str
     * @return bool
     */
    public static function start_width($str, $sub_str)
    {
        return strpos($str, $sub_str) === 0;
    }


    /**
     * @param $str
     * @param $sub_str
     * @return bool
     */
    public static function end_width($str, $sub_str)
    {
        $length = mb_strlen($str) - mb_strlen($sub_str);

        return strpos($str, $sub_str) === $length;
    }

    /**
     * @param $x
     * @param $y
     * @return bool
     */
    public static function same_type($x, $y)
    {
        return gettype($x) === gettype($y);
    }

    /**
     * @param $x
     * @param $y
     * @return bool
     */
    public static function same_class($x, $y)
    {
        return get_class($x) === get_class($y);
    }

    /**
     * @param $check_num
     * @param $min
     * @param $max
     * @return bool
     */
    public static function range($check_num, $min, $max)
    {
        return ($check_num >= $min) && ($check_num <= $max);
    }

    /**
     * @param $num
     * @return bool
     */
    public static function integer($num)
    {
        if (is_integer($num) || is_float($num) || is_string($num)) {
            return !!preg_match('/^-?[0-9]+$/', $num);
        }
    }

}
