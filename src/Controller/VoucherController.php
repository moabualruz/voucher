<?php
declare(strict_types=1);

namespace Voucher\Controller;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Voucher\Entity\Voucher;
use Voucher\Repository\VoucherRepository;
use function json_decode;

class VoucherController extends AbstractController
{
    private VoucherRepository $voucherRepository;
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->voucherRepository = new VoucherRepository($doctrine->getManager(), new ClassMetadata(Voucher::class));
    }

    /**
     * @Route("/vouchers/", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $voucher = (new Voucher())->fromArray($data);

        $this->voucherRepository->save($voucher);

        return new JsonResponse(['status' => 'Voucher created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/vouchers/{id}", name="read", methods={"GET"})
     */
    public function read(int $id): JsonResponse
    {
        $this->voucherRepository = $this->voucherRepository ?? $this->doctrine->getRepository(Voucher::class);
        $voucher = $this->voucherRepository->findOneBy(['id' => $id]);

        return new JsonResponse($voucher->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/vouchers/{id}", name="update", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $voucher = (new Voucher())->fromArray($data)->setId($id);

        $this->voucherRepository->save($voucher);

        return new JsonResponse(['status' => 'Voucher updated!'], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/vouchers/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $voucher = $this->voucherRepository->findOneBy(['id' => $id]);

        $this->voucherRepository->remove($voucher);

        return new JsonResponse(['status' => 'Voucher deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/vouchers", name="list", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $vouchers = $this->voucherRepository->findAll();
        $data = [];

        foreach ($vouchers as $voucher) {
            $data[] = $voucher->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}