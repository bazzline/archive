<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\Template;

class Renderer
{
    public function render(
        array $mapOfTemplateKeyToValue,
        string $templateContent
    ) : string {
        $renderedTemplateContent = str_replace(
            array_keys(
                $mapOfTemplateKeyToValue
            ),
            array_values(
                $mapOfTemplateKeyToValue
            ),
            $templateContent
        );

        return $renderedTemplateContent;
    }
}