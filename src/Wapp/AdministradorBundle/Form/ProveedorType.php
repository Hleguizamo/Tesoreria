<?php

namespace Wapp\AdministradorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProveedorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nit', null, array(
                'attr' => array('autofocus' => true),
                'label' => 'NIT / Usuario',
            ))
			->add('razonSocial', null, array('label' => 'Nombre / Razón Social'))            
			->add('nombreContacto', null, array('label' => 'Nombre Contacto'))            
            ->add('email', 'email', array('label' => 'Email'))
            ->add('contrasena', 'repeated', 
        array('type' => 'password', 'invalid_message' => 'La contraseña no coincide.',
        'first_options'  => array('label' => 'Contraseña'),
        'second_options' => array('label' => 'Confirme la contraseña')))
            //->add('actualizacion', 'datetime')
            //->add('estado')
            //->add('cambioClave', 'date')
           // ->add('ultimaClave')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wapp\AdministradorBundle\Entity\Proveedor'
        ));
    }
}
