<?php
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

namespace VpwDeployTool;

use Zend\ServiceManager\FactoryInterface;
use VpwDeployTool\Environment\LocalEnvironment;
use VpwDeployTool\Environment\EnvironmentFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeployToolFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['vpwdeploytool'];

        $factory = new EnvironmentFactory();

        $development = $factory->create($config['environments']['development']);
        $staging = $factory->create($config['environments']['staging']);
        $production = $factory->create($config['environments']['production']);

        $development->setExcludePatterns($config['exclude_patterns']);

        $deployTool = new DeployTool($development, $staging, $production);

        return $deployTool;
    }

}