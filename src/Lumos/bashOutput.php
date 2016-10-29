<?php

namespace Vinala\Kernel\Console\Command;

use Vinala\Kernel\Objects\Strings;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
* 
*/
class bashOutput
{
	
	/**
	 * the console input
	 * @var OutputInterface
	 */
	public $output;

	function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}

	/**
     * to write in the console
     */
    public function line($text = "")
    {
        $this->output->writeln($text);
    }

    /**
     * to write in the console
     */
    public function write($key)
    {
         $this->output->write($key);
    }

    /**
     * to write text in green color in the console
     */
    public function info($text)
    {
        return "<info>".$text."</info>";
    }

    /**
     * to write text in yellow color in the console
     */
    public function comment($text)
    {
        return "<comment>".$text."</comment>";
    }

    /**
     * to write text in cyan color in the console
     */
    public function question($text)
    {
        return "<question>".$text."</question>";
    }

    /**
     * to write text in red color in the console
     */
    public function error($text)
    {
        return "<error>".$text."</error>";
    }

    /**
     * to write text in red color in the console
     */
    public function red($text)
    {
        return chr(27) . "[1;31m" . "$text" . chr(27) . "[0m";
    }

    /**
     * to write text in green color in the console
     */
    public function green($text)
    {
        return chr(27) . "[1;32m" . "$text" . chr(27) . "[0m";
    }

}