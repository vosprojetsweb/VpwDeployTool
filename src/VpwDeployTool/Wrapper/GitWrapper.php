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

    private $repository;

    public function __construct($repository)
    {
        $this->setRepository($repository);
    }

    public function setRepository($repository)
    {
        $repository = rtrim($repository, '/');
        if (is_dir($repository . '/.git') === false) {
            throw new WrapperException("'$repository' is not a valid git repository.");
        }

        $this->repository = $repository;
    }

    public function getGitDir()
    {
        return $this->repository . '/.git';
    }

    public function getGitWorkTree()
    {
        return $this->repository;
    }

    public function setGitWorkTree($dir)
    {
        $this->repository = $dir;
    }

    public function getFileList()
    {
        $cmd = $this->findExec("git");
        $cmd .= ' ls-files -comd --full-name';

        $output = $this->exec($cmd);

        $files = array();
        foreach ($output as $file) {
            $files[] = $this->repository . '/' . $file;
        }

        return $files;
    }

    public function addAll()
    {
        $cmd = $this->findExec("git");
        $cmd .= " add --all";
        $this->exec($cmd);
    }

    public function commit($message)
    {
        $cmd = $this->findExec("git");
        $cmd .= ' commit --verbose --no-status --message ' .escapeshellarg($message);
        $output = $this->exec($cmd);
    }

    public function findExec($exec)
    {
        $exec = parent::findExec($exec);
        $exec .= ' --git-dir='.escapeshellarg($this->getGitDir());
        $exec .= ' --work-tree='.escapeshellarg($this->getGitWorkTree());

        return $exec;
    }

}