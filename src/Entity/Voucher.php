<?php
declare(strict_types = 1);

namespace Voucher\Entity;

use Voucher\Utils\ObjectAndArray;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Voucher
 *
 * @ORM\Table(name="`voucher`",
 *     indexes={
 *          @ORM\Index(name="`idx_order_user`",
 *              columns={"`userId`"})},
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="`code_unique`",
 *              columns={"`code`"})
 *    }
 * )
 * @ORM\Entity
 */
class Voucher
{
    /**
     * @var int
     *
     * @ORM\Column(name="`id`", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`code`", type="string", length=100, nullable=false)
     */
    private string $code;

    /**
     * @var float
     *
     * @ORM\Column(name="`discount`", type="float", precision=10, scale=0, nullable=false)
     */
    private float $discount = 0.0;

    /**
     * @var bool
     *
     * @ORM\Column(name="`isClaimed`", type="boolean", nullable=false)
     */
    private bool $isClaimed = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="`isPercentage`", type="boolean", nullable=false)
     */
    private bool $isPercentage = false;

    /**
     * @var int|null
     *
     * @ORM\Column(name="`orderId`", type="bigint", nullable=true)
     */
    private ?int $orderId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="`userId`", type="bigint", nullable=true)
     */
    private ?int $userId;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="`createdAt`", type="datetime", nullable=false)
     */
    private DateTime $createdAt;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="`updatedAt`", type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="`extraData`", type="text", length=65535, nullable=true)
     */
    private ?string $extraData;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Voucher
     */
    public function setId(int $id): Voucher
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Voucher
     */
    public function setCode(string $code): Voucher
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return Voucher
     */
    public function setDiscount(float $discount): Voucher
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClaimed(): bool
    {
        return $this->isClaimed;
    }

    /**
     * @param bool $isClaimed
     * @return Voucher
     */
    public function setIsClaimed(bool $isClaimed): Voucher
    {
        $this->isClaimed = $isClaimed;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPercentage(): bool
    {
        return $this->isPercentage;
    }

    /**
     * @param bool $isPercentage
     * @return Voucher
     */
    public function setIsPercentage(bool $isPercentage): Voucher
    {
        $this->isPercentage = $isPercentage;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * @param int|null $orderId
     * @return Voucher
     */
    public function setOrderId(?int $orderId): Voucher
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     * @return Voucher
     */
    public function setUserId(?int $userId): Voucher
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Voucher
     */
    public function setCreatedAt(DateTime $createdAt): Voucher
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return Voucher
     */
    public function setUpdatedAt(?DateTime $updatedAt): Voucher
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExtraData(): ?string
    {
        return $this->extraData;
    }

    /**
     * @param string|null $extraData
     * @return Voucher
     */
    public function setExtraData(?string $extraData): Voucher
    {
        $this->extraData = $extraData;
        return $this;
    }

    use ObjectAndArray;
}
