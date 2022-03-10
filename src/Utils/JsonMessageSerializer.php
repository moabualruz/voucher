<?php

namespace Voucher\Utils;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Stamp\SerializerStamp;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;
use Voucher\Message\OrderEvent;
use function class_exists;
use function sprintf;

class JsonMessageSerializer extends Serializer
{

    private SymfonySerializerInterface $serializer;
    /**
     * @var array|bool[]
     */
    private array $context;
    private string $format;

    public function __construct(SymfonySerializerInterface $serializer = null, string $format = 'json', array $context = [])
    {
        $this->serializer = $serializer ?? self::create()->serializer;
        $this->format = $format;
        $this->context = $context + [self::MESSENGER_SERIALIZATION_CONTEXT => true];
    }

    public static function create(): self
    {
        if (!class_exists(SymfonySerializer::class)) {
            throw new LogicException(sprintf('The "%s" class requires Symfony\'s Serializer component. Try running "composer require symfony/serializer" or use "%s" instead.', __CLASS__, PhpSerializer::class));
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ArrayDenormalizer(), new ObjectNormalizer()];
        $serializer = new SymfonySerializer($normalizers, $encoders);

        return new self($serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have at least a "body", or maybe you should implement your own serializer.');
        }

        try {
            $message = $this->serializer->deserialize($encodedEnvelope['body'], OrderEvent::class, $this->format, [self::MESSENGER_SERIALIZATION_CONTEXT => true]);
        } catch (ExceptionInterface $e) {
            throw new MessageDecodingFailedException('Could not decode message: ' . $e->getMessage(), $e->getCode(), $e);
        }

        return new Envelope($message);
    }

    /**
     * {@inheritdoc}
     */
    public function encode(Envelope $envelope): array
    {
        $context = [self::MESSENGER_SERIALIZATION_CONTEXT => true];
        /** @var SerializerStamp|null $serializerStamp */
        if ($serializerStamp = $envelope->last(SerializerStamp::class)) {
            $context = $serializerStamp->getContext() + $context;
        }

        $envelope = $envelope->withoutStampsOfType(NonSendableStampInterface::class);

        return [
            'body' => $this->serializer->serialize($envelope->getMessage(), $this->format, $context)
        ];
    }
}