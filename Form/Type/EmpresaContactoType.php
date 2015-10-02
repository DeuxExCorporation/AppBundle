<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\EmpresaContacto;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class EmpresaContactoType extends AbstractType
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
            ->add('nombre','text',['label' =>$this->translator->trans ('empresaContacto.form.nombre')])
            ->add('direccion','text',['label' =>$this->translator->trans ('empresaContacto.form.direccion')])
            ->add('ciudad','text',['label' =>$this->translator->trans ('empresaContacto.form.ciudad')])
            ->add('provincia','text',['label' =>$this->translator->trans ('empresaContacto.form.provincia')])
            ->add('pais','text',['label' =>$this->translator->trans ('empresaContacto.form.pais')])
            ->add('telefono','integer',['label' =>$this->translator->trans ('empresaContacto.form.telefono'),'required' => false])
            ->add('movil','integer',['label' =>$this->translator->trans ('empresaContacto.form.movil'),'required' => false])
            ->add('fax','integer',['label' =>$this->translator->trans ('empresaContacto.form.fax'),'required' => false])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\EmpresaContacto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_empresacontacto';
    }

	public function newEntity ()
	{
		$empresa = new EmpresaContacto();

		return $empresa;
	}

	public function isDeletable ($empresa)
	{
		return FALSE;

	}

	public function isChangeable ($empresa)
	{

		return TRUE;
	}

	public function cantCreate ($empresa)
	{

		return TRUE;
	}
}
