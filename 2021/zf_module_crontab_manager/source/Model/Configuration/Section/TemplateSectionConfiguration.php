<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section;

class TemplateSectionConfiguration
{
    /** @var string */
    private $filePathRenderedTemplate;

    /** @var string */
    private $filePathTemplate;

    /** @var array */
    private $listOfTemplateKeyToValue;

    /** @var string */
    private $sectionUniqueIdentifier;

    /**
     * TemplateSectionConfiguration constructor.
     *
     * @param string $filePathRenderedTemplate
     * @param string $filePathTemplate
     * @param string $sectionUniqueIdentifier
     */
    public function __construct(
        string $filePathRenderedTemplate,
        string $filePathTemplate,
        array $listOfTemplateKeyToValue,
        string $sectionUniqueIdentifier
    ) {
        $this->filePathRenderedTemplate = $filePathRenderedTemplate;
        $this->filePathTemplate         = $filePathTemplate;
        $this->listOfTemplateKeyToValue = $listOfTemplateKeyToValue;
        $this->sectionUniqueIdentifier  = $sectionUniqueIdentifier;
    }

    /**
     * @return string
     */
    public function getFilePathRenderedTemplate(): string
    {
        return $this->filePathRenderedTemplate;
    }

    /**
     * @return string
     */
    public function getFilePathTemplate(): string
    {
        return $this->filePathTemplate;
    }

    /**
     * @return array
     */
    public function getListOfTemplateKeyToValue(): array
    {
        return $this->listOfTemplateKeyToValue;
    }

    /**
     * @return string
     */
    public function getSectionUniqueIdentifier(): string
    {
        return $this->sectionUniqueIdentifier;
    }
}