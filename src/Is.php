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
        if ($this->not_flg){
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
        if(php_sapi_name() === $check_string){
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
        if (isset($_SERVER['SERVER_SOFTWARE'])){
            if (strpos($_SERVER['SERVER_SOFTWARE'],$soft_name) !== false){
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
        if(isset($_SERVER['HTTPS'])){
            if ($_SERVER['HTTPS'] === 'on'){
                return $this->_return_result(true);
            }
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
    public function fpm()
    {
        return $this->_check_sapi_name('fpm-fcgi');
    }

    /**
     * @return bool
     */
    public function ios()
    {
        if ($this->_check_browser("iPhone") || $this->_check_browser("iPad") || $this->_check_browser("iPod")){
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

    /**
     * @return bool
     */
    public function safari()
    {
        //最初にChromeが存在しないかチェックする
        if (!$this->_check_browser("Chrome") && $this->_check_browser("Safari")){
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
        if (isset($_SERVER['HTTP_USER_AGENT'])){
            if(strpos($_SERVER['HTTP_USER_AGENT'],$preg_string) !== false){
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function ie()
    {
        return $this->_return_result($this->_check_browser("MSIE"));
    }

    /**
     * @return bool
     */
    public function opera()
    {
        return $this->_return_result($this->_check_browser("Opera"));
    }

    /**
     * @todo SERVER_NAMEは扱いにくい場合がある。他の方法があるようであれば、その方法で実装する。
     * @return bool
     */
    public function localhost()
    {
        if (!isset($_SERVER['SERVER_NAME'])){
            return $this->_return_result(false);
        }

        if ($_SERVER['SERVER_NAME'] === '127.0.0.1' || $_SERVER['SERVER_NAME'] === 'localhost'){
            return $this->_return_result(true);
        }

        return $this->_return_result(false);
    }

    /**
     * @param $lang
     * @return bool
     */
    public function lang($lang)
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return false;
        }

        $server_langs = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($server_langs as $server_lang) {
            if (preg_match('/^'.$lang.'/i',$server_lang)){
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

        foreach($extenstions as $extension){
            if ($extension === $ex){
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
        if ($_SERVER['REQUEST_METHOD'] === $check_type){
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
     * phpunitでテストを実行しているか
     * @return bool
     */
    public function run_unit()
    {
        if(isset($_SERVER['argv'])){
            $argv = $_SERVER['argv'][0];
            if (strpos($argv,'phpunit') !== false){
                return $this->_return_result(true);
            }
        }
        return $this->_return_result(false);
    }

    /**
     * phpspecでテストを実行しているか
     * @return bool
     */
    public function run_spec()
    {
        if(isset($_SERVER['argv'])){
            $argv = $_SERVER['argv'][0];
            if (strpos($argv,'phpspec') !== false){
                return $this->_return_result(true);
            }
        }
        return $this->_return_result(false);
    }

    /**
     * @todo filter_varで簡易的に実装しているが、日本のよくわからないメールアドレスについては対応してないので、そのうち頑張る。
     * @param $mail
     * @return bool
     */
    public function email($mail)
    {
        if (filter_var($mail,FILTER_VALIDATE_EMAIL) !== false){
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
        if (filter_var($url,FILTER_VALIDATE_URL) !== false){
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
        if (filter_var($ip,FILTER_VALIDATE_IP) !== false){
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
        if (filter_var($ip,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4) !== false){
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
        if (filter_var($ip,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6) !== false){
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
        if (preg_match("/^(?:(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/",$num)){
            return $this->_return_result(true);
        }
        return $this->_return_result(false);
    }
}