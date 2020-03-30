<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberRepository")
 */
class Subscriber
{

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true, options={"default" = false})
     */
    protected $isSuspended = false;
    /**
     * @ORM\Column(name="numero", type="bigint")
     * @ORM\Id
     */
    private $numero;
    /**
     * @ORM\Column(name="created_at", type="datetime",nullable=false)
     */
    private $createdAt;
    /**
     * @ORM\Column(name="suspended_at", type="datetime",nullable=true)
     */
    private $suspendedAt;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ConfigMessage")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id", nullable=true))
     **/
    private $message;
    /**
     * @var string
     *
     * @ORM\Column(name="prefered_number", type="array", nullable=false)
     */
    protected $preferedNumber = [];

    /**
     * Get $isSuspended
     *
     * @return boolean
     */
    public function IsSuspended()
    {
        return $this->isSuspended;
    }

    /**
     * @param boolean $isSuspended
     */
    public function setIsSuspended($isSuspended)
    {
        $this->isSuspended = $isSuspended;
    }
    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Subscriber
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }
    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Subscriber
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    /**
     * Get suspendedAt.
     *
     * @return \DateTime
     */
    public function getSuspendedAt()
    {
        return $this->suspendedAt;
    }

    /**
     * Set $suspendedAt.
     *
     * @param \DateTime $suspendedAt
     *
     * @return Subscriber
     */
    public function setSuspendedAt($suspendedAt)
    {
        $this->suspendedAt = $suspendedAt;

        return $this;
    }

    /**
     * Get message
     *
     * @return \App\Entity\ConfigMessage
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param ConfigMessage $message
     *
     * @return Subscriber
     */
    public function setMessage(ConfigMessage $message = null)
    {
        $this->message = $message;

        return $this;
    }
    /**
     * Get preferedNumber
     *
     * @return array
     */
    public function getPreferedNumber()
    {
        return $this->preferedNumber;
    }

    /**
     * Set preferedNumber
     *
     * @param array $preferedNumber
     *
     * @return Subscriber
     */
    public function setPreferedNumber($preferedNumber)
    {
        $this->preferedNumber = $preferedNumber;

        return $this;
    }
}
