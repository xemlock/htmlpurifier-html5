<?php

class BaseTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $errors;

    protected function setUp()
    {
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
}
