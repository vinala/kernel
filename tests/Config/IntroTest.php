<?php


/**
 * ConfigTest for testing.
 */
class IntroTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test on Intro Steps.
     */
    public function testIntroSteps()
    {
        $_POST = $this->mockPost();
        //
        $this->assertTrue(Intro::steps(1));
        $this->assertTrue(Intro::steps(2));
        $this->assertTrue(Intro::steps(3));
        $this->assertTrue(Intro::steps(4));
    }

    private function mockPost()
    {
        return [
            'dev_name'          => 'Youssef',
            'langue'            => 'fr',
            'ckeck_loggin'      => 'false',
            'ckeck_maintenance' => 'false',
            'db_prefix'         => 'fst',
            'sec_1'             => 'abcdefghijklmnopqrstuvwxyz',
            'sec_2'             => 'abcdefghijklmnopqrstuvwxyz',
             ];
    }
}
