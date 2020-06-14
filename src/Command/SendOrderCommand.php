<?php

namespace App\Command;

use App\Entity\NewOrder;
use App\Repository\NewOrderRepository;
use App\Services\Amo\FieldsConverter;
use App\Services\HookHandler\NewLeadHandler;
use DateTimeInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SendOrderCommand
 * @package App\Command
 */
class SendOrderCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:send-order';

    private const COMPLETED_SUCCESSFULLY = 0;

    const LONG_TIME_PERIOD = 25;

    /**
     * @var NewLeadHandler
     */
    private $handler;

    /**
     * @var NewOrderRepository
     */
    private $repository;

    /**
     * @var FieldsConverter
     */
    private $converter;

    /**
     * SendOrderCommand constructor.
     * @param NewLeadHandler $handler
     * @param NewOrderRepository $repository
     * @param FieldsConverter $converter
     */
    public function __construct(NewLeadHandler $handler, NewOrderRepository $repository, FieldsConverter $converter)
    {
        $this->handler = $handler;
        $this->repository = $repository;
        $this->converter = $converter;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Send new orders after 20 minutes');
    }

    /**
     * @deprecated Not needed!
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orders = $this->repository->findNewOrdersForSend();

        foreach ($orders as $order) {
            /**@var $order NewOrder */
            $amo = $this->converter->convert($order->getData());
            $this->handler->sendNew($amo);
        }

        return self::COMPLETED_SUCCESSFULLY;
    }

    /**
     * @param DateTimeInterface $createTime
     * @param DateTimeInterface $sendTime
     * @return bool
     */
    private function isLongTime(DateTimeInterface $createTime, DateTimeInterface $sendTime): bool
    {
        $delta = ($sendTime->format('U') - $createTime->format('U')) / 60;

        return $delta > self::LONG_TIME_PERIOD ? true : false;
    }
}