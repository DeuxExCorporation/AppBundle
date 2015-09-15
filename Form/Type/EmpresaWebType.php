<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\EmpresaWeb;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class EmpresaWebType extends AbstractType
{
	protected $em, $translator;
	public $notList, $notBack;
	public $translatable = true;

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
            ->add('nombre','text',['label' =>$this->translator->trans('empresa.form.nombre') ])
            ->add('email','email',['label' =>$this->translator->trans('empresa.form.email') ])
            ->add('slogan','text',['label' =>$this->translator->trans('empresa.form.slogan') ])
            ->add('archivo','file',['label' =>$this->translator->trans('empresa.form.archivo') ])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('empresa.form.estado'),
		        'choices' => [TRUE => $this->translator->trans ('form.active'),
			        FALSE => $this->translator->trans ('form.desactive')]])
	        ->add('mensajeBloqueo','textarea',['label' =>$this->translator->trans('empresa.form.mensajeBloqueo') ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\EmpresaWeb'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_empresaweb';
    }

	public function newEntity ()
	{
		$empresa = new EmpresaWeb();

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
