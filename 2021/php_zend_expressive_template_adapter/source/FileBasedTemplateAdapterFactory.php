<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-02-04
 */
namespace Net\Bazzline\Component\ZendExpressiveTemplateAdapter;

use Net\Bazzline\Component\Template\FileBasedTemplate;

class FileBasedTemplateAdapterFactory extends AbstractFileBasedTemplateAdapterFactory
{
    /**
     * @return FileBasedTemplate
     */
    protected function getAbstractFileBasedTemplate()
    {
        return new FileBasedTemplate();
    }
}