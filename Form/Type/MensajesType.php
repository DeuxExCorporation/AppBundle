<?php

namespace Destiny\AppBundle\Form\Type;



use Destiny\AppBundle\Entity\Mensajes;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



/**
 * Class NewsletterType
 * @package Destiny\AppBundle\Form
 *

 */
class MensajesType extends AbstractType
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
			->add ('email', 'email', ['label' => $this->translator->trans ('mensajes.form.email'),
									  'disabled' => true])
		->add ('telefono', 'text', ['label' => $this->translator->trans ('mensajes.form.telephone'),
			'disabled' => true])
		->add ('asunto', 'text', ['label' => $this->translator->trans ('mensajes.form.subject'),
			'disabled' => true])
		->add ('cuerpo', 'textarea', ['label' => $this->translator->trans ('mensajes.form.body'),
			'disabled' => true]);
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

	public function newEntity ()
	{
		$mensaje = new Mensajes();

		return $mensaje;
	}

	public function preEdit($mensaje)
	{
		$mensaje->setEstado(true);
		$this->em->persist ($mensaje);
		$this->em->flush ();

		return $mensaje;
	}

	public function isDeletable ($mensaje)
	{

		return TRUE;
	}

	public function isChangeable ($mensaje)
	{

		return TRUE;
	}

	public function listElements ()
	{
		return
			[
				$this->translator->trans ('mensajes.list.subject') => 'asunto'
			];

	}

	public function getMensajesSinLeer()
	{
		 return $this->em->getRepository('DestinyAppBundle:Mensajes')->getMensajesSinLeer();
	}

	public function cantCreate ($mensaje)
	{

		return TRUE;
	}


}
