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


    public function __construct($root, $host)
    {
        parent::__construct($root);

        $this->host = $host;
    }

    public function setOptions($options)
    {
        if (isset($options['sshPort'])) {
            $this->sshPort = intval($options['sshPort']);
        }

        if (isset($options['sshIdentityFile'])) {
            $this->sshIdentityFile = $options['sshIdentityFile'];
        }

        if (isset($options['sshUser'])) {
            $this->sshUser = $options['sshUser'];
        }
    }

    public function getRoot()
    {
        return $this->host . ':' . $this->root;
    }

    public function getSshPort()
    {
        return $this->sshPort;
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