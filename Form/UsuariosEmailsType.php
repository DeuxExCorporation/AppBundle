<?php

namespace Destiny\AppBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class UsuariosEmailsType extends AbstractType
{
    protected $em, $translator;


    public function __construct (EntityManager $em, Translator $translator)
    {
        $this->em = $em;
        $this->translator = $translator;

    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ('asunto', 'text', ['label' => $this->translator->trans ('usuariosEmails.form.title'),
                'max_length' => 150])
            ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('usuariosEmails.form.description')])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\UsuariosEmails'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_usuariosemails';
    }

    public function isDeletable ($empresa)
    {
        return FALSE;

    }

    public function isChangeable ($empresa)
    {

        return FALSE;
    }

    public function cantCreate ($empresa)
    {

        return TRUE;
    }
}
