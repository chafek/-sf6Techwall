<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;    

trait timeStampTrait{
    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $update_at;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    
    #[ORM\PrePersist]
    public function onPrePersist(){
        

        $this->created_at=new \DateTime();
        $this->update_at=new \DateTime();
       
    }

  
    #[ORM\PreUpdate]
    public function onPreUpdate(){
        $this->update_at=new \DateTime();
    }
}