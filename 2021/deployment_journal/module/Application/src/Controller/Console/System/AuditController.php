<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Controller\Console\System;

use Application\Controller\Console\AbstractConsoleController;

class AuditController extends AbstractConsoleController
{
    const ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT   = 'deployment-journal system-audit';
    const ROUTE_NAME_LIST_OF_ARGUMENT           = '';
}