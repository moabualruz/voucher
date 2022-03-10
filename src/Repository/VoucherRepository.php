<?php
declare(strict_types = 1);

namespace Voucher\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Voucher\Entity\Voucher;

class VoucherRepository extends EntityRepository
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager, ClassMetadata $class)
    {
        parent::__construct($manager, $class);
        $this->manager = $manager;
    }

    public function save(Voucher $voucher)
    {
        $this->manager->persist($voucher);
        $this->manager->flush();
    }

    public function remove(Voucher $voucher)
    {
        $this->manager->remove($voucher);
        $this->manager->flush();
    }
}