<?php
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 13 juin 2013
 * Encoding : UTF-8
 */
namespace VpwDeployTool;

use Zend\Stdlib\AbstractOptions;
use VpwDeployTool\Environment\AbstractEnvironment;

class Website extends AbstractOptions
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
     * @var id
     */
    private $id;

    /**
     *
     * @var string
     */
    private $name;

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

    public function getDevelopmentEnvironment()
    {
        return $this->devEnv;
    }

    public function getStagingEnvironment()
    {
        return $this->stagingEnv;
    }

    public function getProductionEnvironment()
    {
        return $this->productionEnv;
    }

    /**
      * @return string
      */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @param name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
      * @return string
      */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}