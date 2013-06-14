<?php
namespace VpwDeployTool\Environment;

use VpwDeployTool\Exception\EnvironmentException;
use Zend\Stdlib\AbstractOptions;
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 10 juin 2013
 * Encoding : UTF-8
 */

abstract class AbstractEnvironment extends AbstractOptions
{

    protected $root;

    protected $url;

    /**
     *
     * @var array
     */
    protected $excludePatterns;

    /**
     * @param string $root root directory
     */
    public function __construct($root = null)
    {
        if ($root !== null) {
            $this->setRoot($root);
        }
    }

    /**
     *
     * @param unknown $root
     * @throws EnvironmentException
     */
    public function setRoot($root)
    {
        if ($this->checkRoot($root) === false) {
            throw new EnvironmentException("'{$dir}' is not a valid root");
        }
        $this->root = $root;
    }

    /**
     *
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     *
     * @param unknown $root
     * @return boolean
     */
    protected function checkRoot($root)
    {
        return is_dir($root) && is_readable($root) && is_writable($root);
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     *
     * @param url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     *
     * @param array $excludePatterns
     */
    public function setExcludePatterns(array $excludePatterns)
    {
        $this->excludePatterns = $excludePatterns;
    }

    /**
     *
     * @return multitype:
     */
    public function getExcludePatterns()
    {
        return $this->excludePatterns;
    }
}