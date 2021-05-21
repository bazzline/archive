<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-14
 */

namespace Test\NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter;

use stdClass;
use Test\NetBazzlineZfCliGenerator\ZfCliGeneratorTestCase;

class RemoveColorsAndModuleHeadlinesTest extends ZfCliGeneratorTestCase
{
    /**
     * @return array
     */
    public function invalidInputProvider()
    {
        return [
            'null'      => [null],
            'int'       => [1],
            'string'    => ['string'],
            'object'    => [new stdClass()]
        ];
    }

    /**
     * @return array
     * @see https://wiki.archlinux.org/index.php/Color_Bash_Prompt#List_of_colors_for_prompt_and_Bash
     */
    public function coloredLinePrefixProvider()
    {
        return [
            ['^[[0;30m'],
            ['^[[0;31m'],
            ['^[[0;32m'],
            ['^[[0;33m'],
            ['^[[0;34m'],
            ['^[[0;35m'],
            ['^[[0;36m'],
            ['^[[0;37m'],
            ['^[[1;30m'],
            ['^[[1;31m'],
            ['^[[1;32m'],
            ['^[[1;33m'],
            ['^[[1;34m'],
            ['^[[1;35m'],
            ['^[[1;36m'],
            ['^[[1;37m'],
            ['^[[4;30m'],
            ['^[[4;31m'],
            ['^[[4;32m'],
            ['^[[4;33m'],
            ['^[[4;34m'],
            ['^[[4;35m'],
            ['^[[4;36m'],
            ['^[[4;37m'],
            ['^[[40m'],
            ['^[[41m'],
            ['^[[42m'],
            ['^[[43m'],
            ['^[[44m'],
            ['^[[45m'],
            ['^[[46m'],
            ['^[[47m'],
            ['^[[0m']
        ];
    }

    /**
     * @expectedException \Net\Bazzline\Component\ProcessPipe\ExecutableException
     * @expectedExceptionMessage input must be an array
     * @dataProvider invalidInputProvider
     * @param $input
     */
    public function testToExecuteItWithNoArrayAsInput($input)
    {
        $process = $this->getNewRemoveColorsAndModuleHeadlines();
        $process->execute($input);
    }

    /**
     * @expectedException \Net\Bazzline\Component\ProcessPipe\ExecutableException
     * @expectedExceptionMessage empty input provided
     */
    public function testToExecuteItWithAnEmptyArrayAsInput()
    {
        $process = $this->getNewRemoveColorsAndModuleHeadlines();
        $process->execute([]);
    }

    /**
     * @dataProvider coloredLinePrefixProvider
     * @param string $prefix
     */
    public function testToExecuteItWithValidInputs($prefix)
    {
        $this->markTestIncomplete();
        $line       = ' tralalala';
        $process    = $this->getNewRemoveColorsAndModuleHeadlines();
        $input = [
            $prefix . $line
        ];
        $output = $process->execute($input);

        $this->assertEquals($line, $output[0]);
        echo var_export($input, true) . PHP_EOL;
        echo var_export($output, true) . PHP_EOL;
    }
}
