<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\BackendSecciones;
use Destiny\AppBundle\Entity\MenusBackend;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class BackendSeccionesType extends AbstractType
{
    protected $translator;
    public $cantCreate;


    public function __construct (Translator $translator, EntityManager $em)
    {
        $this->translator = $translator;
        $this->em = $em;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ('nombre', 'text', ['label' => $this->translator->trans ('menusBackend.form.nombre')])
            ->add ('icono', 'text', ['label' => $this->translator->trans ('menusBackend.form.icono')])
            ->add ('estado', 'choice', ['label' => $this->translator->trans ('menusBackend.form.estado'),
                'choices' => [TRUE => $this->translator->trans ('form.active'),
                    FALSE => $this->translator->trans ('form.desactive')]]);

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\BackendSecciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_menusbackend';
    }



    public function isDeletable ()
    {
        return FALSE;

    }

    public function isChangeable ()
    {

        return TRUE;
    }


    public function groups ()
    {

        $group = $this->em->getRepository('DestinyAppBundle:BackendGruposSecciones')->findAll();

        return $group;


    }

    public function postChange($entidad)
    {


        $seccion = $this->em->getRepository('DestinyAppBundle:BackendPermisos')->findOneBySlug($entidad->getSlug());
        $seccion->setEstado($entidad->getEstado());

        $this->em->persist($seccion);
        $this->em->flush();
    }

    public function newEntity()
    {
        return new BackendSecciones();
    }




}
