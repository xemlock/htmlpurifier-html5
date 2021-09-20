<?php

class BaseTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTMLPurifier_HTML5Config
     */
    protected $config;

    /**
     * @var HTMLPurifier_Context
     */
    protected $context;

    /**
     * @var HTMLPurifier
     */
    protected $purifier;

    /**
     * @var array
     */
    private $errors;

    protected function setUp()
    {
        $this->config = HTMLPurifier_HTML5Config::create(null);
        $this->config->set('Cache.DefinitionImpl', null);

        $this->context = new HTMLPurifier_Context();

        $this->purifier = new HTMLPurifier($this->config);

        $this->errors = array();
        set_error_handler(array($this, 'errorHandler'), E_USER_NOTICE | E_USER_WARNING);
    }

    /**
     * @param int $errno
     * @param string $message
     */
    public function errorHandler($errno, $message)
    {
        $this->errors[] = compact('errno', 'message');
    }

    /**
     * @param string $input
     * @param string $expect OPTIONAL
     */
    public function assertPurification($input, $expect = null)
    {
        $output = $this->purifier->purify($input);

        $this->assertSame($expect !== null ? $expect : $input, $output);
    }

    /**
     * @param string $message
     */
    public function assertWarning($message)
    {
        foreach ($this->errors as $error) {
            if ($error['message'] === $message && $error['errno'] === E_USER_WARNING) {
                return;
            }
        }
        $this->fail("Failed asserting that error of type 'E_USER_WARNING' is triggered.");
    }

    /**
     * Compatibility re-implementation of setExpectedException deprecated in PHPUnit 5.2.0
     * and removed in 6.0.0
     *
     * @param string $exception
     * @param string $message
     * @param int    $code
     * @return void
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection PhpParameterNameChangedDuringInheritanceInspection
     */
    public function setExpectedException($exception, $message = '', $code = null)
    {
        if (method_exists(get_parent_class(__CLASS__), 'setExpectedException')) {
            parent::setExpectedException($exception, $message, $code);
            return;
        }

        $this->expectException($exception);

        if ($message !== null && $message !== '') {
            $this->expectExceptionMessage($message);
        }

        if ($code !== null) {
            $this->expectExceptionCode($code);
        }
    }
}
