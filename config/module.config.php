<?php
use Zend\Navigation\Service\ConstructedNavigationFactory;
return array(
    'service_manager' => array(
        'invokables' => array(
            'VpwDeployTool\DeployTool' => 'VpwDeployTool\DeployTool',
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'vpwdeploytool' => __DIR__ . '/../view',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'VpwDeployTool\Controller\DeployTool' => 'VpwDeployTool\Controller\DeployToolController',
        )
    ),

    'router' => array(
        'routes' => array(
            'VpwDeployTool' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/deployment',
                    'defaults' => array(
                        'controller'    => 'VpwDeployTool\Controller\DeployTool',
                        'action'        => 'selectWebsite',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'showModifiedFiles' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => ':website/source-files',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'VpwDeployTool\Controller\DeployTool',
                                'action'        => 'showModifiedSourceFiles',
                            ),
                        ),
                    ),
                    'putFilestoStaging' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => ':website/put-to-staging',
                            'defaults' => array(
                                'controller'    => 'VpwDeployTool\Controller\DeployTool',
                                'action'        => 'putSourceFilesToStaging',
                            ),
                        ),
                    ),
                    'pendingFiles' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => ':website/pending-files',
                            'defaults' => array(
                                'controller'    => 'VpwDeployTool\Controller\DeployTool',
                                'action'        => 'showDeployablePendingFiles',
                            ),
                        ),
                    ),
                    'deployFiles' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => ':website/deploy-files',
                            'defaults' => array(
                                'controller'    => 'VpwDeployTool\Controller\DeployTool',
                                'action'        => 'deployFiles',
                            ),
                        ),
                    )
                )
            )
        )
    ),
);
