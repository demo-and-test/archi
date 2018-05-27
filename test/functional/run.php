<?php

require __DIR__ . '/../../vendor/autoload.php';

$finder = new \Symfony\Component\Finder\Finder();

$finder->in(__DIR__ . '/tests')
       ->depth('== 0');

define('ARCHI_COMMAND', 'php ' . __DIR__ . '/../../run.php archi');
define('ARCHI_TEST_DIR', '/tmp/test');
define('ARCHI_TEST_DIR_RESULT', '/tmp/test-result');

$fs = new \Symfony\Component\Filesystem\Filesystem();


foreach ($finder as $file) {

    $fs->remove(ARCHI_TEST_DIR);
    $fs->remove(ARCHI_TEST_DIR_RESULT);
    $fs->mkdir(ARCHI_TEST_DIR);
    $fs->mkdir(ARCHI_TEST_DIR_RESULT);

    $test = function ($file) {
        require $file;
    };

    $test($file->getPathname());

    echo "{$file->getRelativePathname()} passed\n";
}
