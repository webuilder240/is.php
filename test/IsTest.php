<?php
namespace Is\Test;

use PHPUnit_Framework_TestCase;

class IsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Is\Is
     */
    private $is;

    /**
     * @var array
     */
    private $defaultSERVER;

    public function setUp()
    {
        $this->is = new \Is\Is();
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
        $this->assertFalse($this->is->ssl());
        $this->assertTrue($this->is->not()->ssl());

        //emulated chrome set always set https : 1
        $this->is->set_SERVER('HTTPS','1');
        $this->assertFalse($this->is->ssl());
        $this->assertTrue($this->is->not()->ssl());

        // emulated ssl
        $this->is->set_SERVER('HTTPS','on');
        $this->is->set_SERVER('HTTP_HTTPS','1');
        $this->assertTrue($this->is->ssl());
        $this->assertFalse($this->is->not()->ssl());

    }

    public function testApache()
    {
        $this->assertFalse($this->is->apache());
        $this->assertTrue($this->is->not()->apache());

        $this->is->set_SERVER('SERVER_SOFTWARE','Apache Version: 2.2.10 (Unix)');
        $this->assertTrue($this->is->apache());
        $this->assertFalse($this->is->not()->apache());
    }

    public function testBuildInServer()
    {
        $this->assertFalse($this->is->build_in_server());
        $this->assertTrue($this->is->not()->build_in_server());

        $this->is->set_SERVER('SERVER_SOFTWARE','PHP 5.6.11 Development Server');
        $this->assertTrue($this->is->build_in_server());
        $this->assertFalse($this->is->not()->build_in_server());
    }

    public function testLocalhost()
    {
        $this->is->set_SERVER('SERVER_NAME',"127.0.0.1");
        $this->assertTrue($this->is->localhost());
        $this->assertFalse($this->is->not()->localhost());

        $this->is->set_SERVER('SERVER_NAME',"0.0.0.0");
        $this->assertTrue($this->is->localhost());
        $this->assertFalse($this->is->not()->localhost());

        $this->is->set_SERVER('SERVER_NAME',"localhost");
        $this->assertTrue($this->is->localhost());
        $this->assertFalse($this->is->not()->localhost());

        $this->is->set_SERVER('SERVER_NAME',"https://webuilder240.github.io/");
        $this->assertFalse($this->is->localhost());
        $this->assertTrue($this->is->not()->localhost());
    }

    public function testRequestGET()
    {
        $this->is->set_SERVER('REQUEST_METHOD','GET');
        $this->assertTrue($this->is->request_get());
        $this->assertFalse($this->is->not()->request_get());

        $this->is->set_SERVER('REQUEST_METHOD','POST');
        $this->assertFalse($this->is->request_get());
        $this->assertTrue($this->is->not()->request_get());
    }

    public function testRequestPOST()
    {
        $this->is->set_SERVER('REQUEST_METHOD','POST');
        $this->assertTrue($this->is->request_post());
        $this->assertFalse($this->is->not()->request_post());

        $this->is->set_SERVER('REQUEST_METHOD','GET');
        $this->assertFalse($this->is->request_post());
        $this->assertTrue($this->is->not()->request_post());
    }

    public function testRequestPUT()
    {
        $this->is->set_SERVER('REQUEST_METHOD','PUT');
        $this->assertTrue($this->is->request_put());
        $this->assertFalse($this->is->not()->request_put());

        $this->is->set_SERVER('REQUEST_METHOD','POST');
        $this->assertFalse($this->is->request_put());
        $this->assertTrue($this->is->not()->request_put());
    }

    public function testRequestPATCH()
    {
        $this->is->set_SERVER('REQUEST_METHOD','PATCH');
        $this->assertTrue($this->is->request_patch());
        $this->assertFalse($this->is->not()->request_patch());

        $this->is->set_SERVER('REQUEST_METHOD','GET');
        $this->assertFalse($this->is->request_patch());
        $this->assertTrue($this->is->not()->request_patch());
    }

    public function testRequestDELETE()
    {
        $this->is->set_SERVER('REQUEST_METHOD','DELETE');
        $this->assertTrue($this->is->request_delete());
        $this->assertFalse($this->is->not()->request_delete());

        $this->is->set_SERVER('REQUEST_METHOD','GET');
        $this->assertFalse($this->is->request_delete());
        $this->assertTrue($this->is->not()->request_delete());
    }

    public function testEmail()
    {
        $this->assertTrue($this->is->email('littlecub240@gmail.com'));
        $this->assertTrue($this->is->not()->email('littlecub240@com'));
        $this->assertFalse($this->is->email('littlecub240@com'));
    }

    public function testUrl()
    {
        $this->assertTrue($this->is->url('http://webuilder240.github.io'));
        $this->assertFalse($this->is->url('littlecub240@com'));
        $this->assertTrue($this->is->not()->url('littlecub240@com'));
        $this->assertFalse($this->is->not()->url('http://webuilder240.github.io'));
    }

    public function testIp()
    {
        //ipv4
        $this->assertTrue($this->is->ip('192.168.56.101'));
        $this->assertTrue($this->is->ip('127.0.0.1'));
        $this->assertFalse($this->is->ip('127.0.0.1256'));
        $this->assertFalse($this->is->not()->ip('10.0.0.5'));

        //ipv6
        $this->assertTrue($this->is->ip('::1'));
        $this->assertTrue($this->is->ip('2001:0db8:1234:5678:90ab:cdef:0000:0000'));
        $this->assertTrue($this->is->ip('2001:db8:0:0:3456::'));

        //others
        $this->assertTrue($this->is->not()->ip('localhost'));
    }

    public function testIpv4()
    {
        //ipv4
        $this->assertTrue($this->is->ipv4('192.168.56.101'));
        $this->assertTrue($this->is->ipv4('127.0.0.1'));
        $this->assertFalse($this->is->ipv4('127.0.0.1256'));
        $this->assertFalse($this->is->not()->ipv4('10.0.0.5'));

        //ipv6
        $this->assertFalse($this->is->ipv4('::1'));
        $this->assertFalse($this->is->ipv4('2001:0db8:1234:5678:90ab:cdef:0000:0000'));
        $this->assertFalse($this->is->ipv4('2001:db8:0:0:3456::'));

        //localhost
        $this->assertTrue($this->is->not()->ipv4('localhost'));
    }

    public function testIpv6()
    {
        //ipv4
        $this->assertFalse($this->is->ipv6('192.168.56.101'));
        $this->assertFalse($this->is->ipv6('127.0.0.1'));
        $this->assertFalse($this->is->ipv6('127.0.0.1256'));
        $this->assertTrue($this->is->not()->ipv6('10.0.0.5'));

        //ipv6
        $this->assertTrue($this->is->ipv6('::1'));
        $this->assertTrue($this->is->ipv6('2001:0db8:1234:5678:90ab:cdef:0000:0000'));
        $this->assertTrue($this->is->ipv6('2001:db8:0:0:3456::'));

        //other
        $this->assertTrue($this->is->not()->ipv6('localhost'));
    }

    public function testCreditcard()
    {
        $this->assertTrue($this->is->creditcard('378282246310005'));
        $this->assertFalse($this->is->creditcard('123'));

        $this->assertTrue($this->is->not()->creditcard('123'));
        $this->assertFalse($this->is->not()->creditcard('4242424242424242'));
    }

    public function testMobile()
    {
        //iPhone
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H143 Safari/600.1.4');
        $this->assertTrue($this->is->mobile());

        //iPod touch
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (iPod touch; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H143 Safari/ 600.1.4');
        $this->assertTrue($this->is->mobile());

        // iPad
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (iPad; CPU OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53');
        $this->assertTrue($this->is->not()->mobile());
        $this->assertFalse($this->is->mobile());

        // Android Mobile
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 6 Build/LMY47Z) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Mobile Safari/537.36');
        $this->assertTrue($this->is->mobile());

        // Android Tablet
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 7 Build/LMY48G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Safari/537.36');
        $this->assertTrue($this->is->not()->mobile());

        // blackberry
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'BlackBerry9000/4.6.0.224 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/220');
        $this->assertTrue($this->is->mobile());

        // chorome
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36');
        $this->assertFalse($this->is->mobile());
    }

    public function testTablet()
    {
        // Android Tablet
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 7 Build/LMY48G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Safari/537.36');
        $this->assertTrue($this->is->tablet());

        // Android Mobile
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (Linux; Android 5.1.1; Nexus 6 Build/LMY47Z) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Mobile Safari/537.36');
        $this->assertFalse($this->is->tablet());
        $this->assertTrue($this->is->not()->tablet());

        // iPad
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (iPad; CPU OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53');
        $this->assertTrue($this->is->tablet());

        //iPhone
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12H143 Safari/600.1.4');
        $this->assertFalse($this->is->tablet());
        $this->assertTrue($this->is->not()->tablet());
    }

    public function testIE()
    {
        // IE8
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/4.0 (compatible; GoogleToolbar 5.0.2124.2070; Windows 6.0; MSIE 8.0.6001.18241)');

        $this->assertTrue($this->is->ie());
        $this->assertTrue($this->is->ie(8));
        $this->assertFalse($this->is->not()->ie(8));

        // IE9
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)');

        $this->assertTrue($this->is->ie());
        $this->assertFalse($this->is->not()->ie());
        $this->assertFalse($this->is->ie(8));
        $this->assertTrue($this->is->ie(9));

        // Not IE
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36');

        $this->assertFalse($this->is->ie());
        $this->assertTrue($this->is->not()->ie());
    }

    public function testChrome()
    {
        // Chrome
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36');

        $this->assertTrue($this->is->chrome());
        $this->assertFalse($this->is->not()->chrome());

        // Not Chrome
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko');

        $this->assertFalse($this->is->chrome());
        $this->assertTrue($this->is->not()->chrome());
    }

    public function testOpera()
    {
        // Opera
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; ja) Presto/2.10.289 Version/12.00');

        $this->assertTrue($this->is->opera());
        $this->assertFalse($this->is->not()->opera());

        // Not Opera
        $this->is->set_SERVER('HTTP_USER_AGENT',
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko');

        $this->assertFalse($this->is->opera());
        $this->assertTrue($this->is->not()->opera());

    }

    public function testFirefox()
    {

    }

    public function testSafari()
    {

    }
}