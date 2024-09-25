<?php

namespace FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands;

use FlexibleCouponsVendor\Symfony\Component\Console\Input\InputArgument;
use FlexibleCouponsVendor\Symfony\Component\Console\Input\InputInterface;
use FlexibleCouponsVendor\Symfony\Component\Console\Output\OutputInterface;
use FlexibleCouponsVendor\Symfony\Component\Yaml\Exception\ParseException;
use FlexibleCouponsVendor\Symfony\Component\Yaml\Yaml;
/**
 * Split test to multiple directories for parallel running in CI.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
class PrepareParallelCodeceptionTests extends \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\BaseCommand
{
    const NUMBER_OF_JOBS = 'number_of_jobs';
    /**
     * Configure command.
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('prepare-parallel-codeception-tests')->setDescription('Prepare parallel codeception tests.')->setDefinition(array(new \FlexibleCouponsVendor\Symfony\Component\Console\Input\InputArgument(self::NUMBER_OF_JOBS, \FlexibleCouponsVendor\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Number of jobs.', '4')));
    }
    /**
     * Execute command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(\FlexibleCouponsVendor\Symfony\Component\Console\Input\InputInterface $input, \FlexibleCouponsVendor\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $numberOfJobs = (int) $input->getArgument(self::NUMBER_OF_JOBS);
        $acceptanceTestsDir = \getcwd() . '/tests/codeception/tests/acceptance';
        for ($i = 1; $i <= $numberOfJobs; $i++) {
            $parallelDir = $acceptanceTestsDir . '/' . $i;
            if (!\file_exists($parallelDir)) {
                \mkdir($parallelDir);
            }
        }
        $currentIndex = 1;
        $files = \scandir($acceptanceTestsDir);
        foreach ($files as $fileName) {
            $fileFullPath = $acceptanceTestsDir . '/' . $fileName;
            if (!\is_dir($fileFullPath)) {
                $targetPath = $acceptanceTestsDir . '/' . $currentIndex . '/' . $fileName;
                \copy($fileFullPath, $targetPath);
                $currentIndex++;
                if ($currentIndex > $numberOfJobs) {
                    $currentIndex = 1;
                }
            }
        }
        return 0;
    }
}
