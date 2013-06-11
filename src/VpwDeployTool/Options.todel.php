<?php
namespace VpwDeployTool;
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 7 juin 2013
 * Encoding : UTF-8
 */

use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{

    private $environmentLocations;

    private $excludePatterns;

    public function __construct($options)
    {
        parent::__construct($options);

        if ($options === null) {
            throw new \InvalidArgumentException("You have to configure the deployement tool");
        }
    }

    public function setEnvironmentLocations(array $locations)
    {
        if (isset($locations['development']) === false) {
            throw new InvalidOptionException("You must define the development environement location");
        }

        if (isset($locations['staging']) === false) {
            throw new InvalidOptionException("You must define the staging environement location");
        }

        if (isset($locations['production']) === false) {
            throw new InvalidOptionException("You must define the production environement location");
        }

        $this->environmentLocations = $locations;
    }

    public function getDevelopmentEnvironmentLocation()
    {
        return $this->environmentLocations['development'];
    }

    public function getStagingEnvironmentLocation()
    {
        return $this->environmentLocations['staging'];
    }

    public function getProductionEnvironmentLocation()
    {
        return $this->environmentLocations['production'];
    }

    protected function setExcludePatterns(array $patterns)
    {
        $this->excludePatterns = $patterns;
    }

    public function getExcludePatterns()
    {
        return $this->excludePatterns;
    }
}