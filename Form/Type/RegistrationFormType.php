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

namespace CCDNUser\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseFormType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormBuilder;

use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;


/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class RegistrationFormType extends BaseFormType
{

    /**
     *
     * @access public
     * @param FormBuilder $builder, array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
        $builder
            //->add('username')
            //->add('email', 'email')
            //->add('plainPassword', 'repeated', array('type' => 'password'))
            ->add('recaptcha', 'ewz_recaptcha', array(
                'property_path' => false,
                'attr' => array(
                    'options' => array(
                        'theme' => 'clean')
                ),
		        //'constraints'   => array(
		        //    new True()
		        //)
            ));
    }

}
