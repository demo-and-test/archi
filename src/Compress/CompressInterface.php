<?php

namespace App\Compress;

/**
 * @author po_taka
 */
interface CompressInterface
{
    /**
     * Add file to the archive
     *
     * @param string $filepath
     */
    public function addFile(string $filepath);

    /**
     * Write data to the archive and close the file handler
     */
    public function close();
}
