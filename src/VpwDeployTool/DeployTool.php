<?php
namespace VpwDeployTool;
use VpwDeployTool\Environment\AbstractEnvironment;
use VpwDeployTool\Wrapper\RsyncWrapper;
use VpwDeployTool\Exception\InvalidArgumentException;
use VpwDeployTool\Exception\DeployToolException;
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
     * @var AbstractEnvironment
     */
    private $devEnv;

    /**
     * @var AbstractEnvironment
     */
    private $stagingEnv;

    /**
     * @var AbstractEnvironment
     */
    private $productionEnv;


    /**
     *
     * @param unknown $development
     * @param unknown $staging
     * @param unknown $production
     */
    public function __construct(
        AbstractEnvironment $development,
        AbstractEnvironment $staging,
        AbstractEnvironment $production
    )
    {
        $this->devEnv = $development;
        $this->stagingEnv = $staging;
        $this->productionEnv = $production;

    }

    /**
     * Returns a list of files which have been modified in the
     * development environement
     * @return array
     */
    public function getModifiedSourceFiles()
    {
        return $this->devEnv->getPendingFiles($this->stagingEnv);
    }

    /**
     * Sync a list of files from the developement environment to the staging environment
     * @param array|traversable $files
     */
    public function putSourceFilesToStaging($files)
    {
        $this->devEnv->synchronizeFiles($this->stagingEnv, $files);
    }

    /**
     * Returns all the files in the staging environment which have not yet been deployed
     * @return array
     */
    public function getDeployablePendingFiles()
    {
        return $this->stagingEnv->getPendingFiles($this->productionEnv);
    }


    public function deploySourceFilesToProduction($files, $message)
    {
        $this->stagingEnv->synchronizeFiles($this->productionEnv, $files, $message);
    }

}