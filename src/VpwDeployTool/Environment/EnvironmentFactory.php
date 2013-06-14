<?php
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

namespace VpwDeployTool\Environment;


use VpwDeployTool\Exception\InvalidArgumentException;
class EnvironmentFactory
{

    public function create($spec)
    {
        $type = isset($spec['type']) ? $spec['type'] : 'VpwDeployTool\Environment\LocalEnvironment';

        switch ($type) {
            default:
                throw new InvalidArgumentException('Bad environment type');
                break;

            case 'VpwDeployTool\Environment\LocalEnvironment':
            case 'VpwDeployTool\Environment\GitEnvironment':
            case 'VpwDeployTool\Environment\RemoteEnvironment':
                $env = new $type();
                unset($spec['type']);
                $env->setFromArray($spec);
                break;
        }

        return $env;
    }

}