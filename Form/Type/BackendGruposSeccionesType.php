<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\GruposMenusBackend;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BackendGruposSeccionesType extends AbstractType
{
    protected $translator;


    public function __construct (Translator $translator)
    {

        $this->translator = $translator;

    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',['label' =>$this->translator->trans('gruposMenusBackend.form.nombre') ])
            ->add('etiqueta','text',['label' =>$this->translator->trans('gruposMenusBackend.form.etiqueta') ])
            ->add ('estado', 'choice', ['label' => $this->translator->trans ('gruposMenusBackend.form.estado'),
                'choices' => [TRUE => $this->translator->trans ('form.active'),
                    FALSE => $this->translator->trans ('form.desactive')]])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\BackendGruposSecciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_backendgrupossecciones';
    }

    public function isDeletable ()
    {

        return TRUE;
    }

    public function isChangeable ()
    {

        return TRUE;
    }

}
