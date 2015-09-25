<?php

namespace Destiny\AppBundle\Form\Type;


use Destiny\AppBundle\Entity\BackendPermisos;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class IdiomasType
 * @package Destiny\AppBundle\Form
 *

 */
class BackendPermisosType extends AbstractType
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
			->add ('estado', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.status'),
				'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
					FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

			->add ('crear', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.create'),
				'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
					          FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

			->add ('editar', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.edit'),
				   					    'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
								 				      FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

			->add ('borrar', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.delete'),
				   						'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
							     					  FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

			->add ('grupos', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.grups'),
										'choices' => [true => $this->translator->trans ('BackendPermisos.form.root')]])
			;

	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults (array (
			'data_class' => 'Destiny\AppBundle\Entity\BackendPermisos'
		));
	}

	/**
	 * @return string
	 */
	public function getName ()
	{
		return 'destiny_appbundle_permisos';
	}

    public function newEntity ()
    {
        return new BackendPermisos();
    }


	public function isDeletable ()
	{
		return false;
	}

	public function isChangeable ($entidad)
	{

		return TRUE;
	}

	public function cantCreate ()
	{

		return TRUE;
	}

	public function postChange($entidad)
	{

		$this->blockeator($entidad->getEntidad(),$entidad->getEstado());
	}

	private function blockeator($entidad, $estado)
	{

		$seccion = $this->em->getRepository('DestinyAppBundle:BackendSecciones')->findOneByDestino($entidad);

		$seccion->setEstado($estado);

		$this->em->persist($seccion);
		$this->em->flush();

	}

}
