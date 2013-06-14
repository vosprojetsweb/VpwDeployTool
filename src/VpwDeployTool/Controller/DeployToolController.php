<?php
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 7 juin 2013
 * Encoding : UTF-8
 */
namespace VpwDeployTool\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use VpwDeployTool\Wrapper\RsyncWrapper;
use Zend\View\Model\ViewModel;
use VpwDeployTool\Exception\DeployToolException;
use VpwDeployTool\Website;
use VpwDeployTool\Environment\EnvironmentFactory;
use Zend\Mvc\MvcEvent;

class DeployToolController extends AbstractActionController
{

    private $avaiblableWebsites = null;

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function selectWebsiteAction()
    {
        return new ViewModel(array(
            'websites' => $this->getAvailableWebsites(),
        ));
    }
    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function showModifiedSourceFilesAction()
    {
        $deployTool = $this->getDeployTool();

        return new ViewModel(array(
            'website' => $this->getSelectedWebsite(),
            'sourceFiles' => $deployTool->getModifiedSourceFiles(),
            'command' => $deployTool->getLastCommand()
        ));
    }


    public function putSourceFilesToStagingAction()
    {
        $files = $this->getRequest()->getPost('files');

        $deployTool = $this->getDeployTool();
        $output = $deployTool->putSourceFilesToStaging($files);

        return new ViewModel(array(
            'output' => $output,
            'website' => $this->getSelectedWebsite(),
        ));
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function showDeployablePendingFilesAction()
    {
        $deployTool = $this->getDeployTool();

        return new ViewModel(array(
            'pendingFiles' => $deployTool->getDeployablePendingFiles(),
            'website' => $this->getSelectedWebsite(),
            'command' => $deployTool->getLastCommand()
        ));
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function deployFilesAction()
    {
        if ($this->getRequest()->isPost() === false) {
            return $this->redirect()->toUrl('/');
        }

        $deployTool = $this->getDeployTool();

        return new ViewModel(array(
            'deployedFiles' => $deployTool->deploySourceFilesToProduction("Mise en production du " . date('d-m-Y h:i:s')),
            'website' => $this->getSelectedWebsite(),
            'command' => $deployTool->getStagingEnvironment()->getLastCommand()
        ));
    }

    /**
     *
     * @return DepoyTool
     */
    private function getDeployTool()
    {
        $deployTool = $this->getServiceLocator()->get('VpwDeployTool\DeployTool');
        $deployTool->setWebsite($this->getSelectedWebsite());
        return $deployTool;
    }

    /**
     *
     * @return Ambigous <\VpwDeployTool\Website>
     */
    private function getSelectedWebsite()
    {
        $websites = $this->getAvailableWebsites();
        $id = $this->getEvent()->getRouteMatch()->getParam('website');

        return $websites[$id];
    }

    /**
     *
     * @return multitype:\VpwDeployTool\Website
     */
    private function getAvailableWebsites()
    {
        if ($this->avaiblableWebsites === null) {
            $config = $this->getServiceLocator()->get('Config')['vpwdeploytool'];

            $this->avaiblableWebsites = array();
            if (isset($config['websites']) === true) {
                $factory = new EnvironmentFactory();

                foreach ($config['websites'] as $id => $config) {

                    $development = $factory->create($config['environments']['development']);
                    $staging = $factory->create($config['environments']['staging']);
                    $production = $factory->create($config['environments']['production']);

                    $development->setExcludePatterns($config['exclude_patterns']);
                    $staging->setExcludePatterns($config['exclude_patterns']);

                    $website = new Website($development, $staging, $production);
                    $website->setName($config['name']);
                    $website->setId($id);

                    $this->avaiblableWebsites[$id] = $website;
                }
            }
        }

        return $this->avaiblableWebsites;
    }
}