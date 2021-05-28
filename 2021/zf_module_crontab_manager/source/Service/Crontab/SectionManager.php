<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\Crontab;

class SectionManager
{
    /** @var string */
    private $uniqueSectionIdentifier;

    /**
     * SectionManager constructor.
     *
     * @param string $uniqueSectionIdentifier
     */
    public function __construct(
        string $uniqueSectionIdentifier
    ) {
        $this->uniqueSectionIdentifier = $uniqueSectionIdentifier;
    }

    public function replaceSectionContent(
        array $listOfFullLine,
        array $listOfNewSectionContentLine
    ) : array {
        $beginSectionLine           = '#begin of ' . $this->uniqueSectionIdentifier;
        $endSectionLine             = '#end of ' . $this->uniqueSectionIdentifier;
        $listOfUpdateLine           = [];
        $newSectionContentWasAdded  = false;
        $weAreInTheSection          = false;

        foreach ($listOfFullLine as $currentLine) {
            if ($currentLine === $beginSectionLine) {
                $weAreInTheSection = true;
                continue;
            }

            if ($currentLine === $endSectionLine) {
                $weAreInTheSection = false;
                continue;
            }

            if ($weAreInTheSection) {
                if ($newSectionContentWasAdded) {
                    continue;
                } else {
                    $listOfUpdateLine[] = $beginSectionLine;
                    foreach ($listOfNewSectionContentLine as $newLine) {
                        $listOfUpdateLine[] = $newLine;
                    }
                    $listOfUpdateLine[] = $endSectionLine;
                    $newSectionContentWasAdded = true;
                }
            } else {
                $listOfUpdateLine[] = $currentLine;
            }
        }

        //handle initial case
        if ($newSectionContentWasAdded === false) {
            $listOfUpdateLine[] = $beginSectionLine;
            $listOfUpdateLine[] = $endSectionLine;
        }

        return $listOfUpdateLine;
    }

    public function sliceSection(
        array $listOfFullLine
    ) : array {
        $beginSectionLine       = '#begin of ' . $this->uniqueSectionIdentifier;
        $beginOfSectionFound    = false;
        $endSectionLine         = '#end of ' . $this->uniqueSectionIdentifier;
        $listOfSectionLine      = [];
        $weAreInTheSection      = false;

        foreach ($listOfFullLine as $currentLine) {
            if ($currentLine === $beginSectionLine) {
                $beginOfSectionFound = true;
                $weAreInTheSection = true;
                continue;
            }

            if ($currentLine === $endSectionLine) {
                $weAreInTheSection = false;
                continue;
            }

            $addToListOfSectionLine = (
                $beginOfSectionFound
                && $weAreInTheSection
            );
            if ($addToListOfSectionLine) {
                $listOfSectionLine[] = $currentLine;
            }
        }

        return $listOfSectionLine;
    }
}