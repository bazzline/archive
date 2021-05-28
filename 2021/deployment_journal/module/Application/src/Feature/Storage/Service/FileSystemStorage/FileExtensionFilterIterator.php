<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-01
 */

namespace Application\Feature\Storage\Service\FileSystemStorage;

use FilterIterator;

class FileExtensionFilterIterator extends FilterIterator
{
    /** @var string */
    private $pattern;

    /**
     * @param string $extension
     */
    public function injectExtensionToFilterFor($extension)
    {
        $this->pattern  = '@\.(' . $extension . ')$@i';
    }

    /**
     * Check whether the current element of the iterator is acceptable
     * @link http://php.net/manual/en/filteriterator.accept.php
     * @return bool true if the current element is acceptable, otherwise false.
     * @since 5.1.0
     */
    public function accept()
    {
        return (
            preg_match(
                $this->pattern,
                $this->current()
            )
        );
    }
}