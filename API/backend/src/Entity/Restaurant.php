<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
/**
 * @OA\Schema(
 *     schema="Restaurant",
 *     title="Restaurante",
 *     description="Un restaurante de la aplicación",
 *     required={"name", "address", "phone"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Pizzería Napoli"),
 *     @OA\Property(property="address", type="string", example="Calle Mayor, 10"),
 *     @OA\Property(property="phone", type="string", example="+34 600 000 000")
 * )
 */
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('restaurant:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('restaurant:read')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('restaurant:read')]
    private ?string $address = null;

    #[ORM\Column(length: 20)]
    #[Groups('restaurant:read')]
    private ?string $phone = null;

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getAddress(): ?string { return $this->address; }
    public function setAddress(string $address): self { $this->address = $address; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(string $phone): self { $this->phone = $phone; return $this; }
}
