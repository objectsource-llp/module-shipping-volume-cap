<?php
declare(strict_types=1);

namespace Objectsource\ShippingVolumeCap\Console;

use Objectsource\ShippingVolumeCap\Cron\ResetShippingCounter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetShippingCountCommand extends Command
{
    /**
     * @var ResetShippingCounter
     */
    protected $resetShippingCounter;

    /**
     * ResetShippingCountCommand constructor.
     * @param ResetShippingCounter $resetShippingCounter
     * @param string|null $name
     */
    public function __construct(
        ResetShippingCounter $resetShippingCounter,
        string $name = null
    ) {
        parent::__construct($name);
        $this->resetShippingCounter = $resetShippingCounter;
    }

    protected function configure()
    {
        $this->setName('volumecap:shippingcount:reset');
        $this->setDescription('Reset shipping counts for volume cap');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->resetShippingCounter->execute();
    }
}
