<?php

namespace Wapp\AdministradorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministradorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('usuario', null, array(
                'attr' => array('autofocus' => true),
                'label' => 'Usuario',
            ))
            ->add('nombre', null, array('label' => 'Nombre'))            
			->add('contrasena', 'repeated', 
        array('type' => 'password', 'invalid_message' => 'La contraseña no coincide.',
        'first_options'  => array('label' => 'Contraseña'),
        'second_options' => array('label' => 'Confirme la contraseña')))
            ->add('email', 'email', array('label' => 'Email'))
            //->add('perfil')
            //->add('estado')
            //->add('public')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wapp\AdministradorBundle\Entity\Administrador'
        ));
    }
}
