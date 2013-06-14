<?php
namespace VpwDeployTool;
use VpwDeployTool\Environment\AbstractEnvironment;
use VpwDeployTool\Wrapper\RsyncWrapper;
use VpwDeployTool\Exception\InvalidArgumentException;
use VpwDeployTool\Exception\DeployToolException;
use VpwDeployTool\Environment\GitEnvironment;
use VpwDeployTool\Wrapper\GitWrapper;
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

class DeployTool
{

    /**
     *
     * @var Website
     */
    private $website;

    private $lastCommand = null;

    public function setWebsite(Website $website)
    {
        $this->website = $website;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    private function getPendingFiles(AbstractEnvironment $src, AbstractEnvironment $dest)
    {
        $rsyncWrapper = new RsyncWrapper($src, $dest);
        $fileList = $rsyncWrapper->getFileList();
        $this->lastCommand = $rsyncWrapper->getLastCommand();
        return $fileList;
    }

    private function synchroniseFiles(AbstractEnvironment $src, AbstractEnvironment $dest, $message=null, $specificFiles = null)
    {
        if ($src instanceof GitEnvironment) {
            try {
                $gitWrapper = new GitWrapper($src->getRoot(), $src->getGitDir());
                $gitWrapper->addAll();
                $gitWrapper->commit($message);
            } catch (\Exception $e) {

            }
        }

        $rsyncWrapper = new RsyncWrapper($src, $dest);
        $output = $rsyncWrapper->synchronizeFiles($specificFiles);
        $this->lastCommand = $rsyncWrapper->getLastCommand();

        return $output;
    }


    /**
     * Returns a list of files which have been modified in the
     * development environement
     * @return array
     */
    public function getModifiedSourceFiles()
    {
        return $this->getPendingFiles(
            $this->website->getDevelopmentEnvironment(),
            $this->website->getStagingEnvironment()
        );
    }

    /**
     * Sync a list of files from the developement environment to the staging environment
     * @param array|traversable $files
     */
    public function putSourceFilesToStaging($files = null)
    {
        return $this->synchroniseFiles(
            $this->website->getDevelopmentEnvironment(),
            $this->website->getStagingEnvironment(),
            null,
            $files
        );
    }

    /**
     * Returns all the files in the staging environment which have not yet been deployed
     * @return array
     */
    public function getDeployablePendingFiles()
    {
        return $this->getPendingFiles(
            $this->website->getStagingEnvironment(),
            $this->website->getProductionEnvironment()
        );
    }


    public function deploySourceFilesToProduction($message, $files = null)
    {
        return $this->synchroniseFiles(
            $this->website->getStagingEnvironment(),
            $this->website->getProductionEnvironment(),
            $message,
            $files
        );
    }


    public function getLastCommand()
    {
        return $this->lastCommand;
    }

}