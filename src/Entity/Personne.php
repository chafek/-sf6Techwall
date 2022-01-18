<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Personne
{

    use TimeStampTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    
     /**
     * @Assert\NotBlank(message="entrez une valeur!")
     * @Assert\Length(min=4,minMessage="entrez 4 caracteres min")
     */
    
    private $firstname;

    #[ORM\Column(type: 'string', length: 50)]
     /**
     * @Assert\NotBlank(message="entrez une valeur!")
     */
    private $name;


    #[ORM\Column(type: 'smallint')]
     /**
     * @Assert\NotBlank(message="entrez une valeur!")
     * @Assert\GreaterThan(10,message="vous devez avoir plus de 10 ans")
     */
    private $age;

 

    #[ORM\OneToOne(inversedBy: 'personne', targetEntity: Profile::class)]
    private $profile;   

    #[ORM\ManyToMany(targetEntity: Hobby::class)]
    private $hobby;

    #[ORM\ManyToOne(targetEntity: Job::class, inversedBy: 'personnes')]
    private $job;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

   

    public function __construct()
    {
        $this->hobby = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

   

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection|Hobby[]
     */
    public function getHobby(): Collection
    {
        return $this->hobby;
    }

    public function addHobby(Hobby $hobby): self
    {
        if (!$this->hobby->contains($hobby)) {
            $this->hobby[] = $hobby;
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): self
    {
        $this->hobby->removeElement($hobby);

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

  

    
}
