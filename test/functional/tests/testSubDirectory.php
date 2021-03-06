<?php

use PHPUnit\Framework\Assert;

$fs = new \Symfony\Component\Filesystem\Filesystem();
$fs->mkdir(ARCHI_TEST_DIR . '/d');
$fs->touch(ARCHI_TEST_DIR . '/d/file', strtotime('now - 40 days'));

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

Assert::assertSame('d/file', $file0['name']);
