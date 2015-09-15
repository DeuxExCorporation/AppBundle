<?php

namespace Destiny\AppBundle\Form\Type;


use Destiny\AppBundle\Entity\EmpresaRedesSociales;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class EmpresaRedesSocialesType extends AbstractType
{
	protected $em, $translator;

	public function __construct (EntityManager $em, Translator $translator)
	{
		$this->em = $em;
		$this->translator = $translator;

	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm (FormBuilderInterface $builder, array $options)
	{
		$builder
			->add ('nombre', 'text', ['label' => $this->translator->trans ('empresaRedesSociales.form.nombre')])
			->add ('iconoFA', 'text', ['label' => $this->translator->trans ('empresaRedesSociales.form.icono')])
			->add ('url', 'url', ['label' => $this->translator->trans ('empresaRedesSociales.form.url')])
			->add ('estado', 'choice', ['label' => $this->translator->trans ('empresaRedesSociales.form.estado'),
				'choices' => [TRUE => $this->translator->trans ('form.active'),
					FALSE => $this->translator->trans ('form.desactive')]]);
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults (array (
			'data_class' => 'Destiny\AppBundle\Entity\EmpresaRedesSociales'
		));
	}

	/**
	 * @return string
	 */
	public function getName ()
	{
		return 'destiny_appbundle_empresaredessociales';
	}

	public function newEntity ()
	{
		$empresa = new EmpresaRedesSociales();

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


}
