<?php

namespace Destiny\AppBundle\Form\Type;


use Destiny\AppBundle\Entity\Idiomas;
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
class IdiomasType extends AbstractType
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
			->add ('nombre', 'text', ['label' => $this->translator->trans ('idiomas.form.name'),
									  'max_length' => 10])
			->add ('isoCode', 'text', ['label' => $this->translator->trans ('idiomas.form.isoCode'),
									   'max_length' => 2])
			->add ('archivo', 'file', ['label' => $this->translator->trans ('idiomas.form.file')])
			->add ('estado', 'choice', ['label' => $this->translator->trans ('idiomas.form.status'),
				'choices' => [TRUE => $this->translator->trans ('form.active'),
					FALSE => $this->translator->trans ('form.desactive')]]);
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults (array (
			'data_class' => 'Destiny\AppBundle\Entity\Idiomas'
		));
	}

	/**
	 * @return string
	 */
	public function getName ()
	{
		return 'destiny_appbundle_idiomas';
	}

	public function newEntity ()
	{
		$idioma = new Idiomas();
        $idioma->setDefecto(FALSE);
		return $idioma;
	}

	public function isDeletable ($idioma)
	{
		if ($idioma->getDefecto () === TRUE) {
			return FALSE;
		}

		return TRUE;
	}

	public function isChangeable ($idioma)
	{
		if ($idioma->getDefecto () === TRUE) {
			return FALSE;
		}

		return TRUE;
	}

	public function listElements ()
	{
		return
			[
				$this->translator->trans ('idiomas.list.isoCode') => 'isoCode',
				$this->translator->trans ('idiomas.list.flag') => 'imagenes',
				$this->translator->trans ('idiomas.list.default') => 'changeStatus'
			];

	}
}
