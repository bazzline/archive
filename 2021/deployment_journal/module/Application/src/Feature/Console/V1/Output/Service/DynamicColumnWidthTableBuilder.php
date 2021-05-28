<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2018-12-15
 */

namespace Application\Feature\Console\V1\Output\Service;

use Application\Service\BuilderInterface;
use Zend\Text\Table\Column;
use Zend\Text\Table\Row;
use Zend\Text\Table\Table;

class DynamicColumnWidthTableBuilder implements BuilderInterface
{
    /** @var array */
    private $listOfHeadlineColumnRow;

    /** @var array */
    private $listOfTableColumnRow;

    public function __construct()
    {
        $this->reset();
    }

    public function addTableColumnRow(
        array $tableColumnRow
    ) {
        //the column is really pissed if you do not add a string, so we are converting all values to a string
        $this->listOfTableColumnRow[] = array_map(
            function($value) {
                return (string) $value;
            },
            $tableColumnRow
        );
    }

    public function setListOfHeadlineColumnRow(
        array $listOfHeadlineColumnRow
    ) {
        $this->listOfHeadlineColumnRow = $listOfHeadlineColumnRow;
    }

    /**
     * @param array $options
     * @todo
     *  * implement option "PADDING" to allow having one or multiple spaces to
     *      the left and the right border
     *
     * @return Table
     */
    public function build(
        array $options = []
    ) {
        //begin of dependencies
        $listOfTableColumnRowWidth  = [];
        $listOfHeadlineColumnRow    = $this->listOfHeadlineColumnRow;
        $listOfTableColumnRow       = $this->listOfTableColumnRow;
        //end of dependencies

        //begin of business logic
        array_unshift($listOfTableColumnRow, $listOfHeadlineColumnRow);

        //begin of initialize the column width
        foreach ($listOfHeadlineColumnRow as $tableColumn) {
            $listOfTableColumnRowWidth[] = 1;
        }
        //end of initialize the column width

        //begin of generating the needed column width
        foreach ($listOfTableColumnRow as $tableColumnRow) {
            foreach ($tableColumnRow as $index => $column) {
                $lengthOfTheColumn = mb_strlen($column);

                if ($listOfTableColumnRowWidth[$index] < $lengthOfTheColumn) {
                    $listOfTableColumnRowWidth[$index] = $lengthOfTheColumn;
                }
            }
        }
        //end of generating the needed column width

        //begin of building the table
        $table = new Table(
            [
                'columnWidths' => $listOfTableColumnRowWidth
            ]
        );

        foreach ($listOfTableColumnRow as $tableColumnRow) {
            $row = new Row();

            foreach ($tableColumnRow as $tableColumn) {
                $row->appendColumn(new Column($tableColumn));
            }

            $table->appendRow($row);
        }
        //end of building the table

        return $table;
        //end of business logic
    }

    /**
     * @return bool
     */
    public function wasAtLeastOneTableColumnRowAdded()
    {
        return (
            !empty(
                $this->listOfTableColumnRow
            )
        );
    }

    public function reset()
    {
        $this->listOfHeadlineColumnRow  = [];
        $this->listOfTableColumnRow     = [];
    }
}
