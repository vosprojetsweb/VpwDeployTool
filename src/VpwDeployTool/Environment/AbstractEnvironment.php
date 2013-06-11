<?php
namespace VpwDeployTool\Environment;

/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

abstract class AbstractEnvironment
{

    protected $root;

    /**
     *
     * @var array
     */
    protected $excludePatterns;

    public function __construct($root)
    {
        $this->setRoot($root);
    }

    public function setRoot($root)
    {
        $this->root = $root;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setExcludePatterns(array $excludePatterns)
    {
        $this->excludePatterns = $excludePatterns;
    }

    abstract public function getPendingFiles(AbstractEnvironment $dest);

    abstract public function synchronizeFiles(AbstractEnvironment $dest, array $files, $message=null);
}