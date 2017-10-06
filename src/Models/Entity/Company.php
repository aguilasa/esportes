<?php
namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="companies")
 */
class Company
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="company", cascade={"remove"})
     */
    public $jobs;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getJobs()
    {
        return $this->jobs->toArray();
    }

    public function addJob(Job $job)
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
        }

        return $this;
    }

    public function removeJob(Job $job)
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
        }

        return $this;
    }

    public function getPeople()
    {
        return array_map(
            function ($job) {
                return $job->getPerson();
            },
            $this->jobs->toArray()
        );
    }

    public function getValues()
    {
        return get_object_vars($this);
    }
}
