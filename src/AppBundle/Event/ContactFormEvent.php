<?php

namespace AppBundle\Event;

use AppBundle\Model\ContactDetail as ContactDetailModel;
use Symfony\Component\EventDispatcher\Event;

class ContactFormEvent extends Event
{
    /** @var ContactDetailModel $contactDetail */
    private $contactDetail;

    public function __construct(ContactDetailModel $contactDetail) {
        $this->contactDetails = $contactDetail;
    }
    public function getContactDetail() {
        return $this->contactDetails;
    }
}