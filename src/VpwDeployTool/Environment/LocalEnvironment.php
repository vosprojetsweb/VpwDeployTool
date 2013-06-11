<?php
namespace VpwDeployTool\Environment;

use VpwDeployTool\Environment\AbstractEnvironment;
use VpwDeployTool\Wrapper\RsyncWrapper;

/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

class LocalEnvironment extends AbstractEnvironment
{

    public function getPendingFiles(AbstractEnvironment $dest)
    {
        $rsyncWrapper = new RsyncWrapper($this->getRoot(), $dest->getRoot());
        $rsyncWrapper->setExcludePatterns($this->excludePatterns);
        return $rsyncWrapper->getFileList();
    }

    public function synchronizeFiles(AbstractEnvironment $dest, array $files, $message=null)
    {
        if (sizeof($files) === 0) {
            throw new DeployToolException('There is no file to put in staging envionment');
        }

        $rsyncWrapper = new RsyncWrapper($this->getRoot(), $desc->getRoot());
        $rsyncWrapper->synchronizeFiles($files);
    }

}