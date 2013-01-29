<?php

/*
 * This file is part of the CCDNUser UserBundle
 *
 * (c) CCDN (c) CodeConsortium <http://www.codeconsortium.com/>
 *
 * Available on github <http://www.github.com/codeconsortium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDNUser\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Sonata\UserBundle\Entity\BaseUser;
use CCDNUser\ProfileBundle\Entity\Profile;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;

/**
 * @ORM\MappedSuperclass
 */
class User extends BaseUser
{
	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="registered_date", type="datetime", nullable=true)
     */
    protected $registeredDate;

    /**
     * @ORM\OneToOne(targetEntity="CCDNUser\ProfileBundle\Entity\Profile", cascade={"persist", "remove"}, orphanRemoval=true)
	 * @ORM\JoinColumn(name="fk_profile_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $profile;

    /**
     * @Recaptcha\True(groups={"Registration"})
     */
    public $recaptcha;

	/**
	 *
	 * @access public
	 */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set profile
     *
     * @param CCDNUser\ProfileBundle\Entity\Profile $profile
     */
    public function setProfile(\CCDNUser\ProfileBundle\Entity\Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Get profile
     *
     * @return CCDNUser\ProfileBundle\Entity\Profile
     */
    public function getProfile()
    {
        if (empty($this->profile)) {
            $this->profile = new Profile();
            $this->profile->setUser($this);
        }

        return $this->profile;
    }

    /**
     * Set registeredDate
     *
     * @param datetime $registeredDate
     */
    public function setRegisteredDate($registeredDate)
    {
        $this->registeredDate = $registeredDate;
    }

    /**
     * Get registeredDate
     *
     * @return datetime
     */
    public function getRegisteredDate()
    {
        return $this->registeredDate;
    }


    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastname();
    }

    /**
     * @param  string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
    	
        $this->facebookUid = $facebookId;
        $this->salt = '';
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookUid;
    }

    /**
     * @param array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
        if (isset($fbdata['username'])) {
            $this->setUsername($fbdata['username']);
        }
    }
}