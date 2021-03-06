<?php

use PHPUnit\Framework\Assert;

$fs = new \Symfony\Component\Filesystem\Filesystem();
$fs->touch(ARCHI_TEST_DIR . '/file');
$fs->touch(
    ARCHI_TEST_DIR . '/file-old',
    time() - 60 * 60 * 24 * 30 - 1 // 30 days and 1 sec old file
);

$fs->touch(
    ARCHI_TEST_DIR . '/file1',
    time() - 60 * 60 * 24 * 30 + 5 // 29 days 23h 59min and 55 sec old file. 5 sec should be enough for execution time
);

$process = new Symfony\Component\Process\Process(
    ARCHI_COMMAND . ' ' . ARCHI_TEST_DIR .  ' ' . ARCHI_TEST_DIR_RESULT . '/1.zip'
);

$process->mustRun();

Assert::assertTrue(
    $fs->exists(ARCHI_TEST_DIR_RESULT . '/1.zip')
);

$zipArchive = new ZipArchive();
$zipArchive->open(ARCHI_TEST_DIR_RESULT . '/1.zip');

Assert::assertSame(1, $zipArchive->numFiles);

$file0 = $zipArchive->statIndex(0);
Assert::assertSame('file-old', $file0['name']);
