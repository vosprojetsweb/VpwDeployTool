<?php
namespace VpwDeployTool\Wrapper;

use VpwDeployTool\Exception\WrapperException;
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
     * Directory to sync
     * @var string
     */
    private $srcDirectory;

    /**
     * The synced directory
     * @var string
     */
    private $destDirectory;


    /**
     * List of patterns
     * @var array
     */
    private $excludePatterns = array();


    public function __construct($src, $dest)
    {
        $this->setSourceDirectory($src);
        $this->setDestinationDirectory($dest);
    }

    public function setSourceDirectory($dir)
    {
        $this->checkDirectory($dir);
        $this->srcDirectory = $dir;
    }

    public function getSourceDirectory()
    {
        return $this->srcDirectory;
    }

    public function setDestinationDirectory($dir)
    {
        $this->checkDirectory($dir);
        $this->destDirectory = $dir;
    }

    public function getDestinationDirectory()
    {
        return $this->destDirectory;
    }

    private function checkDirectory($dir)
    {
        if (is_dir($dir) === false) {
            throw new WrapperException("The file '{$dir}' is not a directory");
        }

        if (is_readable($dir) === false) {
            throw new WrapperException("The directory '{$dir}' is not readable");
        }

        return true;
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
        $cmd .= ' ' . $this->getDefaultOptions();
        $cmd .= ' --verbose';
        $cmd .= ' --dirs';
        $cmd .= ' --dry-run';
        $cmd .= ' --delete';
        $cmd .= ' ' . escapeshellarg($this->getSourceDirectory());
        $cmd .= ' ' . escapeshellarg($this->getDestinationDirectory());
        $cmd .= ' 2>&1';

        exec($cmd, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new WrapperException($output);
        }

        $list = array();
        $size = sizeof($output) - 3;
        for ($i = 1; $i < $size; $i++) {
            $list[] = $output[$i];
        }

        return $list;
    }

    public function synchronizeFiles($files)
    {
        $cmd = '/bin/echo -ne ' . escapeshellarg(implode('\0', $files)) . '|';

        $cmd .= $this->findExec('rsync');
        $cmd .= ' ' . $this->getDefaultOptions();
        $cmd .= ' --verbose';
        $cmd .= ' --dirs';
        $cmd .= ' --dry-run';
        $cmd .= ' --delete';
        $cmd .= ' --files-from=-';
        $cmd .= ' --from0';
        $cmd .= ' --stats';
        $cmd .= ' ' . escapeshellarg($this->getSourceDirectory());
        $cmd .= ' ' . escapeshellarg($this->getDestinationDirectory());
        $cmd .= ' 2>&1';

        exec($cmd, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new WrapperException(implode("\n", $output));
        }

        return $output;
    }

    private function getDefaultOptions()
    {
        $options = "-a --links";

        foreach ($this->getExcludePatterns() as $pattern) {
            $options .= " --exclude=".escapeshellarg($pattern);
        }

        return $options;
    }
}