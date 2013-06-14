<?php
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 7 juin 2013
 * Encoding : UTF-8
 */

namespace VpwDeployTool\Wrapper;

use VpwDeployTool\Wrapper\AbstractWrapper;
use VpwDeployTool\Exception\WrapperException;

class GitWrapper extends AbstractWrapper
{

    private $workTree;

    private $gitDir;

    public function __construct($workTree, $gitDir = null)
    {
        $this->setWorkTree($workTree);

        if ($gitDir !== null) {
            $this->setGitDir($gitDir);
        }
    }

    public function setWorkTree($workTree)
    {
        $this->workTree = $workTree;
    }

    public function getWorkTree()
    {
        return $this->workTree;
    }

    public function setGitDir($gitDir)
    {
        $this->gitDir = $gitDir;
    }

    public function getGitDir()
    {
        if($this->gitDir === null) {
            return $this->workTree . '/.git';
        }

        return $this->gitDir;
    }

    public function addAll()
    {
        $cmd = $this->findExec("git");
        $cmd .= " add --all";
        return $this->exec($cmd);
    }

    public function commit($message)
    {
        $cmd = $this->findExec("git");
        $cmd .= ' commit --verbose --status --message ' .escapeshellarg($message);
        return $this->exec($cmd);
    }

    public function findExec($exec)
    {
        $exec = parent::findExec($exec);
        $exec .= ' --git-dir='.escapeshellarg($this->getGitDir());
        $exec .= ' --work-tree='.escapeshellarg($this->getWorkTree());

        return $exec;
    }

}