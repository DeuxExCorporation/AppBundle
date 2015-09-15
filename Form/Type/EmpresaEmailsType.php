<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\EmpresaEmails;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpresaEmailsType extends AbstractType
{
    protected $em, $translator;
    public $notList, $notBack;

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
            ->add('archivo','file',['label' =>$this->translator->trans('empresaEmails.form.file') ])
            ->add('textoCabecera','text',['label' =>$this->translator->trans('empresaEmails.form.textoCabecera') ])
            ->add('textoPie','text',['label' =>$this->translator->trans('empresaEmails.form.textoPie') ])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\EmpresaEmails'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_empresaemails';
    }

    public function newEntity ()
    {
        $empresa = new EmpresaEmails();

        return $empresa;
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
