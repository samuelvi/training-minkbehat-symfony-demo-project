<?php

namespace AppBundle\Entity;

use AppBundle\Model\ContactDetail as ContactDetailModel;
use Doctrine\ORM\Mapping as ORM;

use AppBundle\Validator\Constraints\Subscription as SubscriptionConstraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Subscription")
 * @ORM\Table(name="subscription")
 */
class Subscription
{
    const STATE_ACTIVE = 1;
    const STATE_PENDING_APPROVAL = 2;
    const STATE_DISABLED = 4;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string", length=250, nullable=false)
     * @Assert\NotBlank(message="E-mail required")
     * @SubscriptionConstraint\EmailUnique()
     */
    protected $email;


    /**
     * @ORM\Column(name="fullname", type="string", length=250, nullable=false)
     * @Assert\NotBlank(message="Full name required")
     */
    protected $fullname;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="state", type="smallint", nullable=false)
     */
    protected $state = self::STATE_PENDING_APPROVAL;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    public static function createFromContactDetail(ContactDetailModel $contactDetailModel)
    {
        $subscriptionEntity = new self();
        $subscriptionEntity->setEmail($contactDetailModel->getEmail());
        $subscriptionEntity->setFullname($contactDetailModel->getFullname());

        return $subscriptionEntity;
    }
}