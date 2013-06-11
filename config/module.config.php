<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'vpwdeploytool' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/vpwdeploytool' => __DIR__ . '/../view/layout/deploytool.phtml',
         )
    ),

    'controllers' => array(
        'invokables' => array(
            'VpwDeployTool\Controller\DeployTool' => 'VpwDeployTool\Controller\DeployToolController',
        )
    ),

    'router' => array(
        'routes' => array(
            'vpwdeploytool' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/deployment',
                    'defaults' => array(
                        'controller'    => 'VpwDeployTool\Controller\DeployTool',
                        'action'        => 'showModifiedSourceFiles',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'putFilestoStaging' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/to-staging',
                            'defaults' => array(
                                'controller'    => 'VpwDeployTool\Controller\DeployTool',
                                'action'        => 'putSourceFilesToStaging',
                            ),
                        ),
                    ),
                    'pendingFiles' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/pending-files',
                            'defaults' => array(
                                'controller'    => 'VpwDeployTool\Controller\DeployTool',
                                'action'        => 'showDeployablePendingFiles',
                            ),
                        ),
                    ),
                    'deployFiles' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/deploy-files',
                            'defaults' => array(
                                'controller'    => 'VpwDeployTool\Controller\DeployTool',
                                'action'        => 'deploySourceFiles',
                            ),
                        ),
                    )
                )
            )
        )
    )
);
