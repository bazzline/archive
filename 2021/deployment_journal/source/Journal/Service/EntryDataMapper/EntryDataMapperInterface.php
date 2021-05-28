<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\EntryDataMapper;

use Net\Bazzline\DeploymentJournal\Journal\Model\Entry;

interface EntryDataMapperInterface
{
    //used to ease up migration if needed
    const CURRENT_VERSION   = '1.0.0';

    const DATA_KEY_CALENDAR_WEEK                    = 'calendar_week';
    const DATA_KEY_CREATED_AT                       = 'created_at';
    const DATA_KEY_CREATED_BY                       = 'created_by';
    const DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT     = 'list_of_affected_environment';
    const DATA_KEY_NAME                             = 'name';
    const DATA_KEY_ENVIRONMENT_NAME                 = 'name';
    const DATA_KEY_TASK_CLASS_NAME_OF_HANDLER       = 'class_name_of_handler';
    const DATA_KEY_TASK_CONTENT                     = 'content';
    const DATA_KEY_TASK_DESCRIPTION                 = 'description';
    const DATA_KEY_TASK_TO_COMMIT                   = 'task_to_commit';
    const DATA_KEY_TASK_TO_REVERT                   = 'task_to_revert';
    const DATA_KEY_VERSION                          = 'version';
    const DATA_KEY_YEAR                             = 'year';
    const DATA_KEY_UUID                             = 'uuid';

    /**
     * @return string
     */
    public function identifier();

    /**
     * @param Entry $entry
     * @return mixed
     */
    public function mapFromEntryToData(Entry $entry);

    /**
     * @param mixed $data
     * @return Entry
     */
    public function mapFromDataToEntry($data): Entry;
}