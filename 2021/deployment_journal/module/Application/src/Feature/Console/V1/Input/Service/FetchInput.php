<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-12-15
 */

namespace Application\Feature\Console\V1\Input\Service;

use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\Request;

class FetchInput
{
    /** @var AdapterInterface */
    private $console;

    public function __construct(
        AdapterInterface $console
    ) {
        $this->console = $console;
    }

    /**
     * @param bool $beVerbose
     * @param string $parameterName
     * @param Request $request
     *
     * @return string
     */
    public function askForSingleLine(
        bool $beVerbose,
        string $parameterName,
        Request $request
    ) : string {
        //begin of dependency
        $console    = $this->console;
        //end of dependency

        //begin of business logic
        $userInput = $request->getParam($parameterName);

        $noInputDoneSoFar = (
            is_null(
                $userInput
            )
        );

        if ($noInputDoneSoFar) {
            $console->writeLine(
                sprintf(
                    ':: Please insert the >>%s<<.',
                    $parameterName
                )
            );

            $userInput = $console->readLine();
        }

        if ($beVerbose) {
            $console->writeLine(
                sprintf(
                    '   You have inserted >>%s<<.',
                    $userInput
                )
            );
        }

        return $userInput;
        //end of business logic
    }

    public function letSelectFromListOfOption(
        bool $beVerbose,
        string $parameterName,
        array $listOfOption,
        Request $request,
        $defaultValue = null,
        bool $multipleOptionsAreAllowed = false
    ) : string {
        //begin of dependency
        $console            = $this->console;
        $listOfOptionIndex  = array_keys($listOfOption);
        //end of dependency

        //begin of business logic
        $userInput = $request->getParam($parameterName);

        $noInputDoneSoFar = (
            is_null(
                $userInput
            )
        );

        if ($noInputDoneSoFar) {
            $this->presentUserHisOption(
                $console,
                $listOfOption,
                $multipleOptionsAreAllowed,
                $defaultValue
            );

            $userInput = $console->readLine();
        }

        if ($beVerbose) {
            $console->writeLine(
                sprintf(
                    '   You input was >>%s<<.',
                    $userInput
                )
            );
        }

        if (
            $multipleOptionsAreAllowed
            && $this->listOfSelectionIsInvalid(
                $listOfOptionIndex,
                $userInput
            )
        ) {
            $userInput = $this->letSelectFromListOfOption(
                $beVerbose,
                $parameterName,
                $listOfOption,
                $request,
                $defaultValue,
                $multipleOptionsAreAllowed
            );
        } else if (
            $this->selectionIsInvalid(
                $listOfOptionIndex,
                $userInput
            )
        ) {
            $userInput = $this->letSelectFromListOfOption(
                $beVerbose,
                $parameterName,
                $listOfOption,
                $request,
                $defaultValue,
                $multipleOptionsAreAllowed
            );
        }

        if ($multipleOptionsAreAllowed) {
            $listOfSelectedOption = explode(
                ',',
                $userInput
            );
            $listOfUserInput = [];

            foreach ($listOfSelectedOption as $selectedOption) {
                $listOfUserInput[] = $listOfOption[$selectedOption];
            }

            $userInput = implode(
                ',',
                $listOfUserInput
            );
        }

        if ($beVerbose) {
            if ($multipleOptionsAreAllowed) {
                $console->writeLine(
                    sprintf(
                        '   You have selected the list of options >>%s<<.',
                        $userInput
                    )
                );
            } else {
                $console->writeLine(
                    sprintf(
                        '   You have selected option >>%s<<.',
                        $userInput
                    )
                );
            }
        }

        return $userInput;
        //end of business logic
    }

    private function listOfSelectionIsInvalid(
        array $listOfOption,
        string $userInput
    ) : bool {
        $isInvalid          = false;
        $listOfUserInput    = explode(
            ',',
            $userInput
        );

        foreach ($listOfUserInput as $currentUserInput) {
            if (
                $this->selectionIsInvalid(
                    $listOfOption,
                    $currentUserInput
                )
            ) {
                $isInvalid = true;
                break;
            }
        }

        return $isInvalid;
    }

    private function presentUserHisOption(
        AdapterInterface $console,
        array $listOfOption,
        bool $multipleOptionsAreAllowed,
        $defaultValue = null
    ) {
        $defaultValueWasProvided = (
            is_null(
                $defaultValue
            )
        );

        if ($defaultValueWasProvided) {
            $console->writeLine(
                ':: Please choose an option.'
            );
        } else {
            $console->writeLine(
                ':: Please choose an option (default is ' . $defaultValue . ').'
            );
        }

        if ($multipleOptionsAreAllowed) {
            $console->writeLine(
                '   Multiple options are allowed, separate them with a >>,<<.'
            );
        }

        foreach ($listOfOption as $index => $option) {
            $console->writeLine(
                '   [' . $index . '] ' . $option
            );
        }
    }



    private function selectionIsInvalid(
        array $listOfOption,
        string $userInput
    ) : bool {

        return (
            !in_array(
                $userInput,
                $listOfOption
            )
        );
    }
}