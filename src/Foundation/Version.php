<?php

namespace Vinala\Kernel\Foundation;

use Vinala\Kernel\Collections\JSON;
use Vinala\Kernel\Filesystem\File;
use Vinala\Kernel\Storage\Cookie;

/**
 * A class to handle the framework and kernel version.
 *
 * @version 1.0
 *
 * @author Youssef Had
 *
 * @since v3.3.0
 */
class Version
{
    //--------------------------------------------------------
    // Properties
    //--------------------------------------------------------

    /**
     * The framework version data.
     *
     * @var array
     */
    protected $framework = null;

    /**
     * The kernel version data.
     *
     * @var array
     */
    protected $kernel = null;

    /**
     * The framework version file path.
     *
     * @var string
     */
    private $frameworkPath = 'VERSION.json';

    /**
     * The kernel version file path.
     *
     * @var string
     */
    private $kernelPath = 'vendor/vinala/kernel/VERSION.json';

    /**
     * The URL of the vinala kernel on the internet.
     *
     * @var string
     */
    private $kernelURL = 'http://raw.githubusercontent.com/vinala/kernel/dev/VERSION.json';

    //--------------------------------------------------------
    // Constructor
    //--------------------------------------------------------

    public function __construct()
    {
        $version = File::get(root().$this->frameworkPath);
        //
        $this->framework = JSON::decode($version, true);
        //

        $version = File::get(root().$this->kernelPath);

        $this->kernel = JSON::decode($version, true);
    }

    //--------------------------------------------------------
    // Functions
    //--------------------------------------------------------

    /**
     * Get the formal version of framework.
     *
     * @return string
     */
    public function version()
    {
        return 'Vinala v'.$this->framework->version.(!empty($this->framework->tag) ? ' '.$this->framework->tag : '').' ('.$this->framework->stat.') PHP Framework';
    }

    /**
     * Get the console format of version of framework.
     *
     * @return string
     */
    public function console()
    {
        return $this->framework->version.(!empty($this->framework->tag) ? ' '.$this->framework->tag : '').' ('.$this->framework->stat.')';
    }

    /**
     * The full version of framework.
     *
     * @return string
     */
    public function full()
    {
        if ($this->framework->stat != 'final') {
            return $this->framework->version.(!empty($this->framework->tag) ? ' '.$this->framework->tag : '').' ('.$this->framework->stat.')';
        } else {
            return $this->framework->version.(!empty($this->framework->tag) ? ' '.$this->framework->tag : '');
        }
    }

    /**
     * Get the kernel version.
     *
     * @return string
     */
    public function kernel()
    {
        return 'Vinala Kernel v'.$this->kernel->version.(!empty($this->kernel->tag) ? ' '.$this->kernel->tag : '').' ('.$this->kernel->stat.')'."\n".$this->kernel->sha;
    }

    /**
     * Set the cookie responsible for the version.
     *
     * @return true
     */
    public function cookie()
    {
        Cookie::create('vinala_version', $this->framework->sha, 3);
    }

    /**
     * To check if there is a new release of kernel.
     *
     * @return bool|array
     */
    public function checkKernel()
    {
        $content = file_get_contents($this->kernelURL);

        $out = JSON::decode($content, true);

        if ($this->compaireSecondary($out->version, $this->kernel->version)
         && ($out->sha != $this->kernel->sha)) {
            return $out;
        } else {
            return false;
        }
    }

    /**
     * Compaire secondary verion.
     *
     * @param string $old
     * @param string $new
     *
     * @return bool
     */
    protected function compaireSecondary($old, $new)
    {
        $oldMajor = dot($old)[0];
        $newMajor = dot($new)[0];

        $oldMinor = dot($old)[1];
        $newMinor = dot($new)[1];

        $oldSecondary = dot($old)[2];
        $newSecondary = dot($new)[2];

        return $oldSecondary != $newSecondary && $oldMajor == $newMajor && $oldMinor == $newMinor;
    }
}
