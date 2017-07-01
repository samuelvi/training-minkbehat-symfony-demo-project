<?php

namespace AppBundle\Model;

use AppBundle\Entity\User as UserEntity;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDetail
{
    /**
     * @Assert\NotBlank(message="The full name can not be empty")
     */
    private $fullname;

    /**
     * @Assert\NotBlank(message="The e-mail can not be empty")
     * @Assert\Email(message="The given e-mail is not valid")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Message subject required")
     */
    private $subject;

    /**
     * @Assert\NotBlank(message="Message required")
     */
    private $message;

    /**
     * @Assert\NotBlank(message="You must accept terms and conditions")
     */
    private $terms;

    private $newsletter;

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
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


    /**
     * @param UserEntity $user
     */
    public static function createFromUser($user) {
        $contactDetailModel = new ContactDetail();
        if (null !== $user) {
            $contactDetailModel->email = $user->getEmail();
            $contactDetailModel->fullname = $user->getFullName();
        }
        return $contactDetailModel;
    }

    /**
     * @return mixed
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param mixed $terms
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
    }

    /**
     * @return mixed
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param mixed $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    }

}