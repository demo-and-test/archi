<?php

namespace App\Compress;

use ZipArchive;

/**
 * Adapter for ZipArchive implementing CompressInterface
 *
 * @author po_taka
 */
class ZipArchiveCompressor implements CompressInterface
{
    /**
     * @var ZipArchive
     */
    private $zipArchive;

    /**
     * @param string $filename where to store the archive
     */
    public function __construct(string $filename)
    {
        $this->zipArchive = new ZipArchive();
        if (true !== $this->zipArchive->open($filename, ZipArchive::EXCL | ZipArchive::CREATE)) {
            throw new CompressException("Cannot open {$filename} or {$filename} already exists");
        }
    }

    /**
     * @inheritDoc
     */
    public function addFile($filename, $localname = null)
    {
        if (true !== $this->zipArchive->addFile($filename, $localname)) {
            throw new CompressException("Can't add {$filename} with location {$localname}");
        }
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        if (true !== $this->zipArchive->close()) {
            throw new CompressException("Error closing archive file");
        }
    }
}
