<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DataMapper\V1\Service;

use InvalidArgumentException;
use Application\Feature\DomainModel\V1\Model\Entry;

interface DataMapperInterface
{
    //used to ease up migration if needed
    const CURRENT_VERSION   = '1.0.0';

    const DATA_KEY_CREATED_AT                       = 'created_at';
    const DATA_KEY_CREATED_BY                       = 'created_by';
    const DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT     = 'list_of_affected_environment';
    const DATA_KEY_NAME                             = 'name';
    const DATA_KEY_ENVIRONMENT_NAME                 = 'name';
    const DATA_KEY_TASK_DESCRIPTION                 = 'description';
    const DATA_KEY_TASK_CLASS_NAME_OF_HANDLER       = 'class_name_of_handler';
    const DATA_KEY_TASK_RELATIVE_PATH_TO_THE_FILE   = 'relative_path_to_the_file';
    const DATA_KEY_TASK_TO_COMMIT                   = 'task_to_commit';
    const DATA_KEY_TASK_TO_REVERT                   = 'task_to_revert';
    const DATA_KEY_VERSION                          = 'version';
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
     * @throws InvalidArgumentException
     */
    public function mapFromDataToEntry($data);
}