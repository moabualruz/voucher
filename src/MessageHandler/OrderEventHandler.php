<?php
declare(strict_types=1);

namespace Voucher\MessageHandler;

use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\Uuid;
use Voucher\Entity\Voucher;
use Voucher\Message\OrderEvent;
use Voucher\Repository\VoucherRepository;
use function strtoupper;

#[AsMessageHandler]
class OrderEventHandler implements MessageHandlerInterface
{

    private ManagerRegistry $doctrine;
    private VoucherRepository $voucherRepository;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->voucherRepository = new VoucherRepository($doctrine->getManager(), new ClassMetadata(Voucher::class));
    }

    /**
     * @param OrderEvent $message
     * @return void
     */
    public function __invoke(OrderEvent $message)
    {
        // 'status' > 7 is when payment is successful and shipping or pickup is scheduled

        if ($message->getOrderData()['grandTotal'] > 100 && $message->getAction() == 'update' && $message->getOrderData()['status'] > 7) {
            // Creat Voucher
            $orderID = $message->getOrderData()['id'];
            $voucher = $this->voucherRepository->findOneBy(['orderId' => $orderID]);


            if ($voucher != null) {
                return;
            }
            $voucher = (new Voucher())->fromArray([
                'code' => strtoupper(Uuid::v4()->jsonSerialize()),
                'discount' => 5.0,
                'isClaimed' => false,
                'isPercentage' => false,
                'orderId' => $orderID,
                'userId' => $message->getOrderData()['userId'],
                'createdAt' => new DateTime(),
            ]);

            $this->voucherRepository->save($voucher);
            // Send Voucher by email to user
        }

    }


}