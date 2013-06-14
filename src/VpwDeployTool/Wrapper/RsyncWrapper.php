<?php
namespace VpwDeployTool\Wrapper;

use VpwDeployTool\Exception\WrapperException;
use VpwDeployTool\Environment\AbstractEnvironment;
use VpwDeployTool\Environment\RemoteEnvironment;
/**
 *
 * @author christophe.borsenberger@vosprojetsweb.pro
 *
 * Created : 7 juin 2013
 * Encoding : UTF-8
 */


class RsyncWrapper extends AbstractWrapper
{

    /**
     * Environment to synchronize
     * @var AbstractEnvironment
     */
    private $src;

    /**
     * The synchronized Environment
     * @var AbstractEnvironment
     */
    private $dest;


    /**
     * List of patterns
     * @var array
     */
    private $excludePatterns = array();


    /**
     *
     * @param AbstractEnvironment $src
     * @param AbstractEnvironment $dest
     */
    public function __construct(AbstractEnvironment $src, AbstractEnvironment $dest)
    {
        $this->setSource($src);
        $this->setDestination($dest);
        $this->setExcludePatterns($src->getExcludePatterns());
    }

    /**
     *
     * @param AbstractEnvironment $env
     */
    public function setSource(AbstractEnvironment $env)
    {
        $this->src= $env;
    }

    /**
     *
     * @return \VpwDeployTool\Environment\AbstractEnvironment
     */
    public function getSource()
    {
        return $this->src;
    }

    /**
     *
     * @param AbstractEnvironment $env
     */
    public function setDestination(AbstractEnvironment $env)
    {
        $this->dest = $env;
    }

    /**
     *
     * @return \VpwDeployTool\Environment\AbstractEnvironment
     */
    public function getDestination()
    {
        return $this->dest;
    }

    /**
     *
     * @param array $patterns
     */
    public function setExcludePatterns(array $patterns)
    {
        $this->excludePatterns = $patterns;
    }


    public function getExcludePatterns()
    {
        return $this->excludePatterns;
    }


    public function getFileList()
    {
        $cmd = $this->findExec('rsync');
        $cmd .= ' --dry-run';
        $cmd .= ' ' . escapeshellarg($this->getSource()->getRoot());
        $cmd .= ' ' . escapeshellarg($this->getDestination()->getRoot());

        $output = $this->exec($cmd);

        $list = array();
        $size = sizeof($output) - 3;
        for ($i = 1; $i < $size; $i++) {
            $filename = $output[$i];
            if(stripos($filename, 'deleting ') === 0) {
                $filename = substr($filename, 9);
            }
            $list[] = new \SplFileInfo($filename);
        }

        return $list;
    }

    public function synchronizeFiles($files)
    {
        $cmd = '';

        if (is_array($files) === true && sizeof($files) > 0) {
            $cmd .= '/bin/echo -ne ' . escapeshellarg(implode('\0', $files)) . '|';
        }

        $cmd .= $this->findExec('rsync');
        $cmd .= ' --stats';

        if (is_array($files) === true && sizeof($files) > 0) {
            $cmd .= ' --files-from=-';
            $cmd .= ' --from0';
        }

        $cmd .= ' ' . escapeshellarg($this->getSource()->getRoot());
        $cmd .= ' ' . escapeshellarg($this->getDestination()->getRoot());

        return $this->exec($cmd);
    }

    public function findExec($exec)
    {
        $exec = parent::findExec($exec) . ' -avz --omit-dir-times --dirs --delete --links';

        foreach ($this->getExcludePatterns() as $pattern) {
            $exec .= " --exclude=".escapeshellarg($pattern);
        }

        if ($this->getDestination() instanceof RemoteEnvironment) {
            $exec .= ' --rsh ' . escapeshellarg($this->getDestination()->getSshCommand());
        }

        return $exec;
    }
}