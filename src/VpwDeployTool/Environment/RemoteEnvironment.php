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

    protected $host;

    protected $sshUser;

    public function __construct($root, $host, $sshUser)
    {
        parent::__construct($root);

        $this->host = $host;
        $this->sshUser = $sshUser;
    }

    public function getRoot()
    {
        return $this->sshUser . '@' . $this->host . ':' . $this->root;
    }
}