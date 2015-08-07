<?php
namespace Is\Test;

use Is\Is;

class IsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $defaultSERVER;

    public function setUp()
    {
        $this->defaultSERVER = $_SERVER;
    }

    public function tearDown()
    {
        $this->_reset_SERVER();
    }

    /**
     * $_SERVERを実行時の状態にリセットする。
     */
    private function _reset_SERVER()
    {
        $_SERVER = $this->defaultSERVER;
    }

    public function testSsl()
    {
        //emulated not ssl
        $this->assertFalse(Is::ssl());

        //emulated chrome set always set https : 1
        $_SERVER['HTTPS'] = 1;
        $this->assertFalse(Is::ssl());

        // emulated ssl
        $_SERVER = [
            'HTTPS' => 'on',
            'HTTP_HTTPS' => 1,
        ];
        $this->assertTrue(Is::ssl());
    }

    public function testApache()
    {
        $this->assertFalse(Is::apache());

        $_SERVER['SERVER_SOFTWARE'] = 'Apache Version: 2.2.10 (Unix)';
        $this->assertTrue(Is::apache());
    }

    public function testBuildInServer()
    {
        $this->assertFalse(Is::build_in_server());
        $_SERVER['SERVER_SOFTWARE'] = 'PHP 5.6.11 Development Server';
        $this->assertTrue(Is::build_in_server());
    }

    public function testLocalhost()
    {
        $_SERVER['SERVER_NAME'] = "127.0.0.1";
        $this->assertTrue(Is::localhost());

        $_SERVER['SERVER_NAME'] = "0.0.0.0";
        $this->assertTrue(Is::localhost());

        $_SERVER['SERVER_NAME'] = "localhost";
        $this->assertTrue(Is::localhost());

        $_SERVER['SERVER_NAME'] = "https://webuilder240.github.io/";
        $this->assertFalse(Is::localhost());
    }

    public function testRequestGET()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue(Is::request_get());

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse(Is::request_get());
    }

    public function testRequestPOST()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertTrue(Is::request_post());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertFalse(Is::request_post());
    }

    public function testRequestPUT()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $this->assertTrue(Is::request_put());

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse(Is::request_put());
    }

    public function testRequestPATCH()
    {
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $this->assertTrue(Is::request_patch());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertFalse(Is::request_patch());
    }

    public function testRequestDELETE()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $this->assertTrue(Is::request_delete());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertFalse(Is::request_delete());
    }

    public function testEmail()
    {
        $this->assertTrue(Is::email('littlecub240@gmail.com'));
        $this->assertFalse(Is::email('littlecub240@com'));
    }

    public function testUrl()
    {
        $this->assertTrue(Is::url('http://webuilder240.github.io'));
        $this->assertFalse(Is::url('littlecub240@com'));
    }

    public function testIp()
    {
        //ipv4
        $this->assertTrue(Is::ip('192.168.56.101'));
        $this->assertTrue(Is::ip('127.0.0.1'));
        $this->assertFalse(Is::ip('127.0.0.1256'));

        //ipv6
        $this->assertTrue(Is::ip('::1'));
        $this->assertTrue(Is::ip('2001:0db8:1234:5678:90ab:cdef:0000:0000'));

        $this->assertFalse(Is::ip('localhost'));
    }

    public function testIpv4()
    {
        //ipv4
        $this->assertTrue(Is::ipv4('192.168.56.101'));
        $this->assertTrue(Is::ipv4('127.0.0.1'));
        $this->assertFalse(Is::ipv4('127.0.0.1256'));

        //ipv6
        $this->assertFalse(Is::ipv4('::1'));
        $this->assertFalse(Is::ipv4('2001:0db8:1234:5678:90ab:cdef:0000:0000'));
        $this->assertFalse(Is::ipv4('2001:db8:0:0:3456::'));

        //localhost
        $this->assertFalse(Is::ipv4('localhost'));
    }

    public function testIpv6()
    {
        //ipv4
        $this->assertFalse(Is::ipv6('192.168.56.101'));
        $this->assertFalse(Is::ipv6('127.0.0.1'));
        $this->assertFalse(Is::ipv6('127.0.0.1256'));

        //ipv6
        $this->assertTrue(Is::ipv6('::1'));
        $this->assertTrue(Is::ipv6('2001:0db8:1234:5678:90ab:cdef:0000:0000'));
        $this->assertTrue(Is::ipv6('2001:db8:0:0:3456::'));

        //other
        $this->assertFalse(Is::ipv6('localhost'));
    }

    public function testCreditcard()
    {
        $this->assertTrue(Is::creditcard('378282246310005'));
        $this->assertFalse(Is::creditcard('123'));
        $this->assertTrue(Is::creditcard('4242424242424242'));
    }

    public function testMobile()
    {
        //iPhone
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H143 Safari/600.1.4';
        $this->assertTrue(Is::mobile());

        //iPod touch
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (iPod touch; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H143 Safari/ 600.1.4';
        $this->assertTrue(Is::mobile());

        // iPad
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (iPad; CPU OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53';
        $this->assertFalse(Is::mobile());

        // Android Mobile
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 6 Build/LMY47Z) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Mobile Safari/537.36';
        $this->assertTrue(Is::mobile());

        // Android Tablet
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 7 Build/LMY48G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Safari/537.36';
        $this->assertFalse(Is::mobile());

        // blackberry
        $_SERVER['HTTP_USER_AGENT'] =
            'BlackBerry9000/4.6.0.224 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/220';
        $this->assertTrue(Is::mobile());

        // chorome
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36';
        $this->assertFalse(Is::mobile());
    }

    public function testTablet()
    {
        // Android Tablet
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 7 Build/LMY48G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Safari/537.36';
        $this->assertTrue(Is::tablet());

        // Android Mobile
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 6 Build/LMY47Z) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Mobile Safari/537.36';
        $this->assertFalse(Is::tablet());

        // iPad
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (iPad; CPU OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53';
        $this->assertTrue(Is::tablet());

        //iPhone
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H143 Safari/600.1.4';
        $this->assertFalse(Is::tablet());
    }

    public function testIE()
    {
        // IE8
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/4.0 (compatible; GoogleToolbar 5.0.2124.2070; Windows 6.0; MSIE 8.0.6001.18241)';

        $this->assertTrue(Is::ie());
        $this->assertTrue(Is::ie(8));

        // IE9
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)';

        $this->assertTrue(Is::ie());
        $this->assertFalse(Is::ie(8));
        $this->assertTrue(Is::ie(9));

        // Not IE
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36';

        $this->assertFalse(Is::ie());
    }

    public function testChrome()
    {
        // Chrome
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36';

        $this->assertTrue(Is::chrome());

        // Not Chrome
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko';

        $this->assertFalse(Is::chrome());
    }

    public function testOpera()
    {
        // Opera
        $_SERVER['HTTP_USER_AGENT'] =
            'Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; ja) Presto/2.10.289 Version/12.00';

        $this->assertTrue(Is::opera());

        // Not Opera
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko';

        $this->assertFalse(Is::opera());

    }

    public function testFirefox()
    {
        // Firefox
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0';

        $this->assertTrue(Is::firefox());

        // Not Firefox
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko';

        $this->assertFalse(Is::firefox());
    }

    public function testSafari()
    {
        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A';

        $this->assertTrue(Is::safari());

        $_SERVER['HTTP_USER_AGENT'] =
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko';

        $this->assertFalse(Is::safari());
    }

    public function testRemoteStatusCode()
    {
        $this->assertTrue(Is::http_status_code('http://ozuma.sakura.ne.jp/httpstatus/200', '200'));
        $this->assertTrue(Is::http_status_code('http://ozuma.sakura.ne.jp/httpstatus/201', 201));
        $this->assertTrue(Is::http_status_code('http://ozuma.sakura.ne.jp/httpstatus/400', 400));
        $this->assertFalse(Is::http_status_code('http://ozuma.sakura.ne.jp/httpstatus/501', 500));
    }

    public function testStrInclude()
    {
        $this->assertTrue(Is::str_include('nick', 'n'));
        $this->assertFalse(Is::str_include('takuya', 'nishi'));
    }

    public function testSameType()
    {
        $this->assertTrue(Is::same_type('1', '1'));
        $this->assertFalse(Is::same_type(1, '1'));
        $this->assertFalse(Is::same_type(1, 1.0));
    }

    public function testSameClass()
    {
        require_once 'testClass.php';
        $test = new \testClass\testClass1();
        $test2 = new \testClass\testClass1();
        $test3 = new \testClass\sampleClass1();
        $test4 = new \testClass\sampleClass2();
        $this->assertTrue(Is::same_class($test, $test2));
        $this->assertFalse(Is::same_class($test, $test3));
        $this->assertFalse(Is::same_class($test3, $test4));
    }

    public function testStartWidth()
    {
        $this->assertTrue(Is::start_width('text', 'tex'));
        $this->assertFalse(Is::start_width('abc', 'bc'));
    }

    public function testEndWidth()
    {
        $this->assertTrue(Is::end_width('test', 'est'));
        $this->assertFalse(Is::end_width('test', 'tes'));
    }

    public function testRenge()
    {
        $this->assertTrue(Is::range(100, 1, 100));
        $this->assertFalse(Is::range(1000, 1, 100));
        $this->assertFalse(Is::range(1, 10, 100));
    }

    public function testIsInteger()
    {
        $this->assertTrue(Is::integer('111'));
        $this->assertFalse(Is::integer('1.11'));
        $this->assertTrue(Is::integer(111));
        $this->assertFalse(Is::integer(1.11));
        $this->assertFalse(Is::integer('string'));
    }

}
