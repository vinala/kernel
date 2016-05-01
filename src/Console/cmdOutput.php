<?php

namespace Pikia\Kernel\Console\Command;

use Pikia\Kernel\Objects\Strings;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
* 
*/
class cmdOutput
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
    public function line($text)
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
        $text = chr(27) . "[1;32m" . "$text" . chr(27) . "[0m";
        $this->line($text);
    }

    /**
     * to write text in yellow color in the console
     */
    public function comment($text)
    {
        $text = chr(27) . "[1;33m" . "$text" . chr(27) . "[0m";
        $this->line($text);
    }

    /**
     * to write text in cyan color in the console
     */
    public function question($text)
    {
        $text = chr(27) . "[1;36m" . "$text" . chr(27) . "[0m";
        $this->line($text);
    }

    /**
     * to write text in red color in the console
     */
    public function error($text)
    {
        $text = chr(27) . "[1;31m" . "$text" . chr(27) . "[0m";
        $this->line($text);
    }

}