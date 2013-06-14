<?php
namespace VpwDeployTool\Environment;

use VpwDeployTool\Environment\AbstractEnvironment;

/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

class RemoteEnvironment extends LocalEnvironment
{

    protected $sshUser;

    protected $host;

    protected $sshPort;

    protected $sshIdentityFile;


    public function __construct($root = null, $host = null)
    {
        parent::__construct($root);

        $this->host = $host;
    }

    /**
     * The root isn't easily checkable, so we return always true
     *
     * (non-PHPdoc)
     * @see \VpwDeployTool\Environment\AbstractEnvironment::checkRoot()
     */
    protected function checkRoot($root)
    {
        return true;
    }

    public function getRoot()
    {
        return $this->host . ':' . $this->root;
    }

    /**
      * @return string
      */
    public function getHost()
    {
        return $this->host;
    }

    /**
     *
     * @param host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
      * @return string
      */
    public function getSshUser()
    {
        return $this->sshUser;
    }

    /**
     *
     * @param sshUser
     */
    public function setSshUser($sshUser)
    {
        $this->sshUser = $sshUser;
    }

    public function setSshPort($port)
    {
        $this->sshPort = intval($port);
    }

    public function getSshPort()
    {
        return $this->sshPort;
    }

    public function setSshIdentityFile($file)
    {
        $this->sshIdentityFile = $file;
    }

    public function getSshIdentityFile()
    {
        return $this->sshIdentityFile;
    }

    public function getSshCommand()
    {
        $options = array();

        if ($this->sshIdentityFile !== null) {
            $options[] = '-i ' . escapeshellarg($this->sshIdentityFile);
        }

        if ($this->sshPort !== null) {
            $options[] = '-p ' . escapeshellarg($this->sshPort);
        }

        if ($this->sshPort !== null) {
            $options[] = '-l ' . escapeshellarg($this->sshUser);
        }

        if (sizeof($options) > 0) {
            return 'ssh ' . implode(' ', $options);
        }

        return '';
    }
}