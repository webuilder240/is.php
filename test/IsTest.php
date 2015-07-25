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

        $_SERVER['HTTPS'] = 'on';
        $this->assertTrue($this->is->ssl());
        $this->assertFalse($this->is->not()->ssl());
    }

    public function testApache()
    {
        $this->assertFalse($this->is->apache());
        $this->assertTrue($this->is->not()->apache());

        $_SERVER['SERVER_SOFTWARE'] = 'Apache Version: 2.2.10 (Unix)';

        $this->assertTrue($this->is->apache());
        $this->assertFalse($this->is->not()->apache());
    }

    public function testBuildInServer()
    {
        $this->assertFalse($this->is->build_in_server());
        $this->assertTrue($this->is->not()->build_in_server());

        $_SERVER['SERVER_SOFTWARE'] = 'PHP 5.6.11 Development Server';

        $this->assertTrue($this->is->build_in_server());
        $this->assertFalse($this->is->not()->build_in_server());
    }

    public function testLocalhost()
    {
        $_SERVER['SERVER_NAME'] = "127.0.0.1";
        $this->assertTrue($this->is->localhost());
        $this->assertFalse($this->is->not()->localhost());

        $_SERVER['SERVER_NAME'] = "localhost";
        $this->assertTrue($this->is->localhost());
        $this->assertFalse($this->is->not()->localhost());

        $_SERVER['SERVER_NAME'] = "https://webuilder240.github.io/";
        $this->assertFalse($this->is->localhost());
        $this->assertTrue($this->is->not()->localhost());
    }

    public function testRequestGET()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue($this->is->request_get());
        $this->assertFalse($this->is->not()->request_get());

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse($this->is->request_get());
        $this->assertTrue($this->is->not()->request_get());
    }

    public function testRequestPOST()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertTrue($this->is->request_post());
        $this->assertFalse($this->is->not()->request_post());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertFalse($this->is->request_post());
        $this->assertTrue($this->is->not()->request_post());
    }

    public function testRequestPUT()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $this->assertTrue($this->is->request_put());
        $this->assertFalse($this->is->not()->request_put());

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse($this->is->request_put());
        $this->assertTrue($this->is->not()->request_put());
    }

    public function testRequestPATCH()
    {
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $this->assertTrue($this->is->request_patch());
        $this->assertFalse($this->is->not()->request_patch());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertFalse($this->is->request_patch());
        $this->assertTrue($this->is->not()->request_patch());
    }

    public function testRequestDELETE()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $this->assertTrue($this->is->request_delete());
        $this->assertFalse($this->is->not()->request_delete());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertFalse($this->is->request_delete());
        $this->assertTrue($this->is->not()->request_delete());
    }

    public function testRunUnit()
    {
        $this->assertTrue($this->is->run_unit());
        $this->assertFalse($this->is->not()->run_unit());

        $_SERVER['argv'][0] = "";
        $this->assertFalse($this->is->run_unit());
        $this->assertTrue($this->is->not()->run_unit());

        $_SERVER['argv'][0] = "vendor/bin/phpspec";
        $this->assertFalse($this->is->run_unit());
        $this->assertTrue($this->is->not()->run_unit());
    }

    public function testRunSpec()
    {
        $_SERVER['argv'][0] = "vendor/bin/phpspec";
        $this->assertTrue($this->is->run_spec());
        $this->assertFalse($this->is->not()->run_spec());

        $_SERVER['argv'][0] = "vendor/bin/phpunit";
        $this->assertFalse($this->is->run_spec());
        $this->assertTrue($this->is->not()->run_spec());
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
}