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

    public function getPendingFiles(AbstractEnvironment $dest)
    {
        $gitWrapper = new GitWrapper($this->getRoot());
        return $gitWrapper->getFileList();
    }

    public function synchronizeFiles(AbstractEnvironment $dest, array $files, $message=null)
    {
        //Commit Stuff
        $gitWrapper = new GitWrapper($this->getRoot());
        $gitWrapper->addAll();
        $gitWrapper->commit($message);

        parent::synchronizeFiles($dest, $files);
    }


}