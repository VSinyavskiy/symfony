<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 *
 * @ORM\Table(name="employees")
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeePhone", mappedBy="employee", orphanRemoval=true)
     */
    private $employeePhones;

    public function __construct()
    {
        $this->employeePhones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|EmployeePhone[]
     */
    public function getEmployeePhones(): Collection
    {
        return $this->employeePhones;
    }

    public function addEmployeePhone(EmployeePhone $employeePhone): self
    {
        if (!$this->employeePhones->contains($employeePhone)) {
            $this->employeePhones[] = $employeePhone;
            $employeePhone->setEmployeeId($this);
        }

        return $this;
    }

    public function removeEmployeePhone(EmployeePhone $employeePhone): self
    {
        if ($this->employeePhones->contains($employeePhone)) {
            $this->employeePhones->removeElement($employeePhone);
            // set the owning side to null (unless already changed)
            if ($employeePhone->getEmployeeId() === $this) {
                $employeePhone->setEmployeeId(null);
            }
        }

        return $this;
    }
}
