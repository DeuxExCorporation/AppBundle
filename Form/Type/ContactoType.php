<?php

namespace Destiny\AppBundle\Form\Type;



use Destiny\AppBundle\Entity\Mensajes;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



/**
 * Class NewsletterType
 * @package Destiny\AppBundle\Form
 *

 */
class ContactoType extends AbstractType
{
	protected $translator;


	public function __construct (Translator $translator)
	{

		$this->translator = $translator;

	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm (FormBuilderInterface $builder, array $options)
	{
		$builder
			->add ('email', 'email', ['label' => $this->translator->trans ('mensajes.form.email')])
		->add ('telefono', 'text', ['label' => $this->translator->trans ('mensajes.form.telephone')])
		->add ('asunto', 'text', ['label' => $this->translator->trans ('mensajes.form.subject')])
		->add ('cuerpo', 'textarea', ['label' => $this->translator->trans ('mensajes.form.body')]);
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions (OptionsResolver $resolver)
	{
		$resolver->setDefaults (array (
				'data_class' => 'Destiny\AppBundle\Entity\Mensajes'
		));
	}

	/**
	 * @return string
	 */
	public function getName ()
	{
		return 'destiny_appbundle_mensajes';
	}


}
