<?php

declare (strict_types=1);
namespace FlexibleCouponsVendor\WPDesk\Codeception\Runner\Command;

use FlexibleCouponsVendor\Symfony\Component\Console\Command\Command;
use FlexibleCouponsVendor\Symfony\Component\Console\Input\InputInterface;
use FlexibleCouponsVendor\Symfony\Component\Console\Output\OutputInterface;
use FlexibleCouponsVendor\WPDesk\Codeception\Runner\DockerCompose;
use FlexibleCouponsVendor\WPDesk\Codeception\Runner\RuntimeMode;
final class PullCommand extends Command
{
    public function __construct(private readonly DockerCompose $dockerCompose, private readonly RuntimeMode $runtimeMode)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->setName('pull')->setDescription('Download the newest local WP Desk test stack images.');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->runtimeMode->isDirect()) {
            $output->writeln('<info>Direct runtime detected; no Docker images to pull.</info>');
            return self::SUCCESS;
        }
        return $this->dockerCompose->pull($output);
    }
}
