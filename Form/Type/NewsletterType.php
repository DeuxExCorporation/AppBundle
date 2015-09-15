<?php

namespace Destiny\AppBundle\Form\Type;



use Destiny\AppBundle\Entity\Newsletter;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class NewsletterType
 * @package Destiny\AppBundle\Form
 *

 */
class NewsletterType extends AbstractType
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
			->add ('email', 'text', ['label' => $this->translator->trans ('newsletter.form.email'),
									  'max_length' => 100]);
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults (array (
				'data_class' => 'Destiny\AppBundle\Entity\Newsletter'
		));
	}

	/**
	 * @return string
	 */
	public function getName ()
	{
		return 'destiny_appbundle_newsletter';
	}

	public function newEntity ()
	{
		$newsletter = new Newsletter();

		return $newsletter;
	}

	public function postCreate($newsletter)
	{
		$newsletter->setEstado(True);

		return $newsletter;
	}

	public function isDeletable ($newsletter)
	{

		return TRUE;
	}

	public function isChangeable ($newsletter)
	{

		return TRUE;
	}

	public function listElements ()
	{
		return null;
	}
}
