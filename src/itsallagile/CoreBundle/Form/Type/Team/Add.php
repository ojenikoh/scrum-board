<?php
namespace itsallagile\CoreBundle\Form\Type\Team;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\Extension\Core\Type\RepeatedType,
    Symfony\Component\Form\FormBuilderInterface;

class Add extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'itsallagile\CoreBundle\Entity\Team');
    }

    public function getName()
    {
        return 'team';
    }
}