<?php
namespace VpwDeployTool\Environment;

use VpwDeployTool\Environment\LocalEnvironment;
use VpwDeployTool\Wrapper\GitWrapper;

/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

class GitEnvironment extends LocalEnvironment
{

    private $gitDir;

    public function __construct($root = null, $gitDir = null)
    {
        parent::__construct($root);

        if ($gitDir != null) {
            $this->setGitDir($gitDir);
        }

    }

    public function setGitDir($gitDir)
    {
        $this->gitDir = $gitDir;
    }

    public function getGitDir()
    {
        return $this->gitDir;
    }
}