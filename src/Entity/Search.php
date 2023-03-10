<?php
namespace App\Entity;
class Search
        {

        private $ville;
        private $destination; 
        private $date; 
        private $nbp;

                public function getVille(): ?string

                {
                    return $this->ville;
                }

                public function setVille(string $ville): self

                {
                    $this->ville = $ville;
                    return $this;
                }


                public function getDestination(): ?string

                {
                    return $this->destination;
                }
                
                public function setDestination(string $destination): self

                {
                    $this->destination = $destination;
                    return $this;
                }


                public function getNbp(): ?string

                {
                    return $this->nbp;
                }
                
                public function setNbp(string $nbp): self

                {
                    $this->nbp = $nbp;
                    return $this;
                }


                public function getDate(): ?\DateTimeInterface
                {
                    return $this->date;
                }
            
                public function setDate(\DateTimeInterface $date): self
                {
                    $this->date = $date;
            
                    return $this;
                }

        }