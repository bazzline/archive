<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-02
 */

namespace Net\Bazzline\DeploymentJournal\Service\Builder;

interface BuilderInterface
{
    /**
     * @return mixed
     */
    public function build();
}