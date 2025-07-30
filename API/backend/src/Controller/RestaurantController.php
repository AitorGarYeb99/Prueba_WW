<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/restaurants')]
class RestaurantController extends AbstractController
{
    private function serialize(Restaurant $restaurant): array
    {
        return [
            'id' => $restaurant->getId(),
            'name' => $restaurant->getName(),
            'address' => $restaurant->getAddress(),
            'phone' => $restaurant->getPhone(),
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/restaurants",
     *     summary="Listar todos los restaurantes",
     *     @OA\Response(
     *         response=200,
     *         description="Listado de restaurantes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Restaurant"))
     *     ),
     *     security={{"ApiKeyAuth": {}}}
     * )
     */
    #[Route('', methods: ['GET'])]
    public function list(RestaurantRepository $repo): JsonResponse
    {
        $data = array_map(
            fn(Restaurant $r) => $this->serialize($r),
            $repo->findAll()
        );
        return $this->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/restaurants",
     *     summary="Crear un nuevo restaurante",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Restaurante creado",
     *         @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *     ),
     *     security={{"ApiKeyAuth": {}}}
     * )
     */
    #[Route('', methods: ['POST'])]
    #[Route('', methods: ['POST'])]
public function create(Request $request, EntityManagerInterface $em): JsonResponse
{
    try {
        $data = json_decode($request->getContent(), true);

        // Validación de campos requeridos
        if (!isset($data['name'], $data['address'], $data['phone']) ||
            empty($data['name']) || empty($data['address']) || empty($data['phone'])) {
            return $this->json(['error' => 'All fields are required'], 400);
        }

        // Crear y guardar restaurante
        $restaurant = new Restaurant();
        $restaurant->setName($data['name']);
        $restaurant->setAddress($data['address']);
        $restaurant->setPhone($data['phone']);

        $em->persist($restaurant);
        $em->flush();

        return $this->json($this->serialize($restaurant), 201);
    } catch (\Throwable $e) {
        // Mostramos el mensaje de error exacto para poder depurar
        return $this->json(['error' => $e->getMessage()], 500);
    }
}


    /**
     * @OA\Get(
     *     path="/api/restaurants/{id}",
     *     summary="Obtener un restaurante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del restaurante",
     *         @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *     ),
     *     security={{"ApiKeyAuth": {}}}
     * )
     */
    #[Route('/{id}', methods: ['GET'])]
    public function getOne(Restaurant $restaurant): JsonResponse
    {
        return $this->json($this->serialize($restaurant));
    }

    /**
     * @OA\Put(
     *     path="/api/restaurants/{id}",
     *     summary="Actualizar restaurante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurante actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Restaurant")
     *     ),
     *     security={{"ApiKeyAuth": {}}}
     * )
     */
    #[Route('/{id}', methods: ['PUT'])]
    public function update(Restaurant $restaurant, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (isset($data['name'])) $restaurant->setName($data['name']);
        if (isset($data['address'])) $restaurant->setAddress($data['address']);
        if (isset($data['phone'])) $restaurant->setPhone($data['phone']);
        $em->flush();
        return $this->json($this->serialize($restaurant));
    }

    /**
     * @OA\Delete(
     *     path="/api/restaurants/{id}",
     *     summary="Eliminar restaurante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Restaurante eliminado"
     *     ),
     *     security={{"ApiKeyAuth": {}}}
     * )
     */
    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Restaurant $restaurant, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($restaurant);
        $em->flush();
        return $this->json(null, 204);
    }
}
