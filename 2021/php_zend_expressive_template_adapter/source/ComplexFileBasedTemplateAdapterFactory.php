<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-02-07
 */
namespace Net\Bazzline\Component\ZendExpressiveTemplateAdapter;

use Net\Bazzline\Component\Template\ComplexFileBasedTemplate;

class ComplexFileBasedTemplateAdapterFactory extends AbstractFileBasedTemplateAdapterFactory
{
    /**
     * @return ComplexFileBasedTemplate
     */
    protected function getAbstractFileBasedTemplate()
    {
        return new ComplexFileBasedTemplate();
    }
}