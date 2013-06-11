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

class DeployToolController extends AbstractActionController
{

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function showModifiedSourceFilesAction()
    {
        $deployTool = $this->getServiceLocator()->get('VpwDeployTool\DeployTool');

        return new ViewModel(array(
            'root' => $deployTool->getDevelopmentEnvironment()->getRoot(),
            'sourceFiles' => $deployTool->getModifiedSourceFiles()
        ));
    }


    public function putSourceFilesToStagingAction()
    {
        //$files = ;
        $files = $this->getRequest()->getPost('files');

        $deployTool = $this->getServiceLocator()->get('VpwDeployTool\DeployTool');
        $deployTool->putSourceFilesToStaging($files, $output);

        return new ViewModel(array(
            'output' => $output,
        ));
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function showDeployablePendingFilesAction()
    {
        $deployTool = $this->getServiceLocator()->get('VpwDeployTool\DeployTool');

        return new ViewModel(array(
            'pendingFiles' => $deployTool->getDeployablePendingFiles()
        ));
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function deploySourceFiles()
    {
        $deployTool = $this->getServiceLocator()->get('VpwDeployTool\DeployTool');

        return new ViewModel(array(
            'deployedFiles' => $deployTool->getDeployablePendingFiles()
        ));
    }
}