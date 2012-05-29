<?php
namespace itsallagile\CoreBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilder;

class Registration extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('fullName', 'text');
        $builder->add('email', 'email');
        $builder->add('password', 'repeated', array(
           'first_name' => 'password',
           'second_name' => 'confirm',
           'type' => 'password'
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'itsallagile\CoreBundle\Entity\User');
    }

    public function getName()
    {
        return 'user';
    }
}