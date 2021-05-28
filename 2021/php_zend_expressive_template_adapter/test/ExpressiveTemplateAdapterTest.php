<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-02-03
 */
namespace Test\Net\Bazzline\Component\Template;

use Net\Bazzline\Component\ZendExpressiveTemplateAdapter\ExpressiveTemplateAdapter;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit_Framework_TestCase;

class ExpressiveTemplateAdapterTest extends PHPUnit_Framework_TestCase
{
    /** @var string */
    private $filePath;

    /** @var vfsStreamDirectory */
    private $fileSystem;

    protected function setUp()
    {
        $this->fileSystem   = vfsStream::setup();

        $file               = vfsStream::newFile('template');
        $this->fileSystem->addChild($file);
        $this->filePath     = $file->url();
    }

    public function testAddMultiplePaths()
    {
        $adapter                = $this->createTemplateAdapter();
        $fileNames              = array(
            'template01.phtml',
            'template02.phtml',
            'template03.phtml'
        );
        /** @var array|vfsStreamFile[] $pathToFileCollection */
        $pathToFileCollection   = array();

        foreach ($fileNames as $fileName) {
            $file = $this->createFile($fileName);
            $this->addFileToFileSystem($file);
            $pathToFileCollection[$file->url()] = $file;
        }

        foreach ($pathToFileCollection as $file) {
            $adapter->addPath($file->url());
        }

        foreach ($adapter->getPaths() as $path) {
            $pathWasAdded = isset($pathToFileCollection[$path->getPath()]);
            $this->assertTrue($pathWasAdded);
        }
    }

    /**
     * @param vfsStreamFile $file
     */
    private function addFileToFileSystem(vfsStreamFile $file)
    {
        $this->fileSystem->addChild($file);
    }

    /**
     * @param string $name
     * @return \org\bovigo\vfs\vfsStreamFile
     */
    private function createFile($name)
    {
        return vfsStream::newFile($name);
    }

    /**
     * @return ExpressiveTemplateAdapter
     */
    private function createTemplateAdapter()
    {
        return new ExpressiveTemplateAdapter();
    }
}