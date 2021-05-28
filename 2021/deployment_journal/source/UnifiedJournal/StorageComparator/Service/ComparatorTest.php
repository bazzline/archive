<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\Comparator\Service;

class ComparatorTest
{
    public function testCompare()
    {
        //begin of dependencies
        $comparator     = new Comparator();
        $globalStorage  = Mockery::mock(StorageInterface::class);
        $localStorage   = Mockery::mock(StorageInterface::class);
        //end of dependencies

        //begin of business logic
        //end of business logic
    }
}