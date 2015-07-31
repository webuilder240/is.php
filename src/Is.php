<?php
namespace Is;

/**
 * Class Is
 * @package Is
 */
class Is
{
    /**
     * @var bool
     */
    private $not_flg = false;

    /**
     * $_SERVER
     * @var array
     */
    private $_SERVER;
    private $same_name;

    /**
     * set $_SERVER,$php_same_name
     */
    public function __construct()
    {
        $this->_SERVER = $_SERVER;
        $this->same_name = php_sapi_name();
    }

    /**
     * テスト用にSet出来るようにしている。
     * 本当はsetできない方向にしたい
     *
     * for unit test
     */
    public function set_SERVER($key, $value)
    {
        if ($value !== null) {
            $this->_SERVER[$key] = $value;
        }
    }

    /**
     * テスト用にSet出来るようにしている。
     * 本当はsetできない方向にしたい
     *
     * for unit test
     */
    public function set_php_same_name($value)
    {
        $this->php_same_name = $value;
    }

    /**
     * @return $this
     */
    public function not()
    {
        $this->not_flg = true;

        return $this;
    }

    /**
     * @param bool $pre_result
     * @return bool
     */
    private function _return_result($pre_result)
    {
        if ($this->not_flg) {
            $this->not_flg = false;
            return !$pre_result;
        }

        return $pre_result;
    }

    /**
     * @param $check_string
     * @return bool
     */
    private function _check_sapi_name($check_string)
    {
        if (php_sapi_name() === $check_string) {
            return $this->_return_result(true);
        }
        return $this->_return_result(false);
    }

    /**
     * @return bool
     */
    public function apache()
    {
        return $this->_return_result($this->_check_server_software("Apache"));
    }

    /**
     * @return bool
     */
//    public function nginx()
//    {
//    }

    /**
     * @return bool
     */
//    public function iis()
//    {
//    }

    /**
     * @param $soft_name
     * @return bool
     */
    private function _check_server_software($soft_name)
    {
        if (isset($this->_SERVER['SERVER_SOFTWARE'])) {
            if (strpos($this->_SERVER['SERVER_SOFTWARE'], $soft_name) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function ssl()
    {
        if (isset($this->_SERVER['HTTPS']) && isset($this->_SERVER['HTTP_HTTPS'])) {
            if ($this->_SERVER['HTTPS'] === 'on' || $this->_SERVER['HTTP_HTTPS'] === '1') {
                return $this->_return_result(true);
            }
        }
        return $this->_return_result(false);
    }

    /**
     * @return bool
     */
    public function localhost()
    {
        if (!isset($this->_SERVER['SERVER_NAME'])) {
            return $this->_return_result(false);
        }

        if ($this->_SERVER['SERVER_NAME'] === '127.0.0.1' || $this->_SERVER['SERVER_NAME'] === 'localhost' || $this->_SERVER['SERVER_NAME'] === '0.0.0.0') {
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }

    /**
     * @param $host string
     * @return bool
     */
    public function host($host)
    {
        if (!isset($this->_SERVER['SERVER_NAME'])) {
            return $this->_return_result(false);
        }

        if ($host === "localhost" || $host === '127.0.0.1' || $host === '0.0.0.0') {
            return $this->localhost();
        }

        if ($this->_SERVER['SERVER_NAME'] === $host) {
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }

    /**
     * @param $ip string
     * @return bool
     */
    public function host_ip($ip)
    {
        if (!isset($this->_SERVER['SERVER_ADDR'])) {
            return $this->_return_result(false);
        }

        if ($this->_SERVER['SERVER_ADDR'] === $ip) {
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }


    /**
     * @return bool
     */
    public function build_in_server()
    {
        return $this->_return_result($this->_check_server_software("Development"));
    }

    /**
     * @return bool
     */
    public function cli()
    {
        return $this->_check_sapi_name('cli');
    }

    /**
     * @return bool
     */
    public function ios()
    {
        if ($this->_check_browser("iPhone") || $this->_check_browser("iPad") || $this->_check_browser("iPod")) {
            return $this->_return_result(true);
        }
        return $this->_return_result(false);
    }

    /**
     * @return bool
     */
    public function android()
    {
        return $this->_return_result($this->_check_browser("Android"));
    }

    public function phone()
    {
        return $this->mobile();
    }

    /**
     * @return bool
     */
    public function mobile()
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
                $result = $this->_check_mobile_agent($mobile, 'mobile');
            } else {
                $result = $this->_check_mobile_agent($mobile);
            }
            if ($result) {
                return $this->_return_result(true);
            }
        }

        return $this->_return_result(false);
    }

    /**
     * @return bool
     */
    public function tablet()
    {
        $ua = mb_strtolower($this->_SERVER['HTTP_USER_AGENT']);
        $tablet_lists = [
            'ipad',
            'android',
            'kindle',
            'firefox',
            'playbook',
            'windows',
        ];

        foreach ($tablet_lists as $tablet) {

            if ($tablet === 'android') {
                if (strpos($ua, 'android') !== false && strpos($ua, 'mobile') === false) {
                    $result = true;
                } else {
                    $result = false;
                }
            } elseif ($tablet === 'firefox') {
                if (strpos($ua, 'firefox') !== false && strpos($ua, 'tablet') !== false) {
                    $result = true;
                } else {
                    $result = false;
                }
            } elseif ($tablet === 'windows') {
                if (strpos($ua, 'windows') !== false && strpos($ua, 'touch') !== false) {
                    $result = true;
                } else {
                    $result = false;
                }
            } elseif ($tablet === 'kindle') {
                if (strpos($ua, 'kindle') !== false || strpos($ua, 'silk') !== false) {
                    $result = true;
                } else {
                    $result = false;
                }
            } else {
                $result = $this->_check_mobile_agent($tablet);
            }

            if ($result) {
                return $this->_return_result(true);
            }
        }

        return $this->_return_result(false);
    }

    /**
     * @param $params
     */
    private function _check_mobile_agent($params, $key = null)
    {
        $ua = mb_strtolower($this->_SERVER['HTTP_USER_AGENT']);
        if ($key) {
            if (strpos($ua, $params) !== false && strpos($ua, $key) !== false) {
                return true;
            }
        } else {
            if (strpos($ua, $params) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function safari()
    {
        //最初にChromeが存在しないかチェックする
        if (!$this->_check_browser("Chrome") && $this->_check_browser("Safari")) {
            return $this->_return_result(true);
        }
        return $this->_return_result(false);
    }

    /**
     * @return bool
     */
    public function chrome()
    {
        return $this->_return_result($this->_check_browser("Chrome"));
    }

    /**
     * @return bool
     */
    public function firefox()
    {
        return $this->_return_result($this->_check_browser("Firefox"));
    }

    /**
     * @param $preg_string
     * @return bool
     */
    private function _check_browser($preg_string)
    {
        if (isset($this->_SERVER['HTTP_USER_AGENT'])) {
            if (strpos($this->_SERVER['HTTP_USER_AGENT'], $preg_string) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $version int
     * @return bool
     */
    public function ie($version = null)
    {
        if ($version) {
            $version = strval($version) . '.0';
            if ($this->_check_browser("MSIE") && strpos($this->_SERVER['HTTP_USER_AGENT'], $version) !== false) {
                return $this->_return_result(true);
            }
            return $this->_return_result(false);
        } else {
            return $this->_return_result($this->_check_browser("MSIE"));
        }
    }

    /**
     * @return bool
     */
    public function opera()
    {
        return $this->_return_result($this->_check_browser("Opera"));
    }

    /**
     * @param $lang
     * @return bool
     */
    public function lang($lang)
    {
        if (!isset($this->_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return false;
        }

        $server_langs = explode(",", $this->_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($server_langs as $server_lang) {
            if (preg_match('/^' . $lang . '/i', $server_lang)) {
                return $this->_return_result(true);
            }
        }
        return $this->_return_result(false);
    }

    /**
     * @param $ex
     * @return bool
     */
    public function load_extension($ex)
    {
        $extenstions = get_loaded_extensions();

        foreach ($extenstions as $extension) {
            if ($extension === $ex) {
                return $this->_return_result(true);
            }
        }

        return $this->_return_result(false);
    }

    /**
     * @param $check_type
     * @return bool
     */
    private function _check_http_method($check_type)
    {
        if ($this->_SERVER['REQUEST_METHOD'] === $check_type) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function request_get()
    {
        return $this->_return_result($this->_check_http_method('GET'));
    }

    /**
     * @return bool
     */
    public function request_post()
    {
        return $this->_return_result($this->_check_http_method('POST'));
    }

    /**
     * @return bool
     */
    public function request_delete()
    {
        return $this->_return_result($this->_check_http_method('DELETE'));
    }

    /**
     * @return bool
     */
    public function request_put()
    {
        return $this->_return_result($this->_check_http_method('PUT'));
    }

    /**
     * @return bool
     */
    public function request_patch()
    {
        return $this->_return_result($this->_check_http_method('PATCH'));
    }

    /**
     * @todo filter_varで簡易的に実装しているが、日本のよくわからないメールアドレスについては対応してないので、そのうち頑張る。
     * @param $mail
     * @return bool
     */
    public function email($mail)
    {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL) !== false) {
            return $this->_return_result(true);
        }
        return $this->_return_result(false);
    }

    /**
     * @param $url
     * @return bool
     */
    public function url($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            return $this->_return_result(true);
        }
        return $this->_return_result(false);
    }

    /**
     * @param $ip
     * @return bool
     */
    public function ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }

    /**
     * @param $ip
     * @return bool
     */
    public function ipv4($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }

    /**
     * @param $ip
     * @return bool
     */
    public function ipv6($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }

    /**
     * @param $num
     * @return bool
     */
    public function creditcard($num)
    {
        if (preg_match("/^(?:(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/", $num)) {
            return $this->_return_result(true);
        }
        return $this->_return_result(false);
    }

    /**
     *
     * URLが取得できない場合はfile_get_contentsにて普通に例外を投げます。
     *
     * @param $uri
     * @param $http_status_code
     * @return bool
     */
    public function http_status_code($uri,$http_status_code)
    {
        $context = stream_context_create([
            'http' => ['ignore_errors' => true]
        ]);

        file_get_contents($uri,null,$context,0,1);
        preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
        $status_code = $matches[1];

        if ($status_code == $http_status_code){
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }

    /**
     * @param $str
     * @param $sub_str
     * @return bool
     */
	public function str_include($str, $sub_str)
	{
		return $this->_return_result(
			strpos($str,$sub_str) !== false
		);
	}

    /**
     * @param $str
     * @param $sub_str
     * @return bool
     */
    public function start_width($str, $sub_str)
    {
        return $this->_return_result(
            strpos($str, $sub_str) === 0
        );
    }


    /**
     * @param $str
     * @param $sub_str
     * @return bool
     */
    public function end_width($str, $sub_str)
    {
        $length = mb_strlen($str) - mb_strlen($sub_str);
        return $this->_return_result(
            strpos($str,$sub_str) === $length
        );
    }

    /**
     * @param $x
     * @param $y
     * @return bool
     */
	public function same_type($x, $y)
	{
		return $this->_return_result(
			gettype($x) === gettype($y)
		);
	}

    /**
     * @param $x
     * @param $y
     * @return bool
     */
	public function same_class($x,$y)
	{
		return $this->_return_result(
			get_class($x) === get_class($y)
		);
	}

    /**
     * @param $check_num
     * @param $min
     * @param $max
     * @return bool
     */
    public function range($check_num,$min,$max)
    {
        return $this->_return_result(
            ($check_num >= $min) && ($check_num <= $max)
        );
    }
}
