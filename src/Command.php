<?php

namespace App;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use App\Compress\ZipArchiveCompressor;

/**
 * @author po_taka
 */
class Command extends BaseCommand
{
    protected function configure()
    {
        $this->setName('archi')
             ->setDescription('archive old files')
             ->addArgument('directory', InputArgument::REQUIRED, 'Directory to archive')
             ->addArgument('filepath', InputArgument::REQUIRED, 'filepath for the created archve');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = $input->getArgument("directory");

        $output->writeln("Scanning {$directory}");

        $finder = new Finder();
        $finder->files()->in($directory)
                        ->date('> now - 30 days'); // @TODO make days configurable?

        // this could be fetched from DI container, but we don't need such complex logic atm
        $zipArchive = new ZipArchiveCompressor($input->getArgument('filepath'));

        foreach ($finder as $file) {
            $output->writeln(
                "Adding {$file->getRealPath()} with archive name {$file->getRelativePathname()}",
                OutputInterface::VERBOSITY_DEBUG
            );
            $zipArchive->addFile($file->getRealPath(), $file->getRelativePathname());
        }

        $zipArchive->close();
    }
}
