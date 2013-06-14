<?php
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 7 juin 2013
 * Encoding : UTF-8
 */

namespace VpwDeployTool\Wrapper;


use VpwDeployTool\Exception\WrapperException;

abstract class AbstractWrapper
{
    private $lastCommand;

    public function findExec($exec)
    {
        foreach($this->getPaths() as $path) {
            $file = $path . '/' . $exec;

            if (file_exists($file) === true) {

                if (is_executable($file) === false) {
                    throw new WrapperException("The file '{$file}' is not executable");
                }

                return $file;
            }
        }

        throw new WrapperException("The file '$exec' has not been found.");
    }

    public function  getPaths()
    {
        if (isset($_ENV['PATH']) === true) {
            return explode(':', $_ENV['PATH']);
        }
        if (isset($_SERVER['PATH']) === true) {
            return explode(':', $_SERVER['PATH']);
        }

        return array();
    }

    public function exec($cmd)
    {
        $this->lastCommand = $cmd;

        exec($cmd .' 2>&1', $output, $returnVar);

        if ($returnVar !== 0) {
            throw new WrapperException(implode("\n", $output), $returnVar);
        }

        return $output;
    }

    public function getLastCommand()
    {
        return $this->lastCommand;
    }
}
