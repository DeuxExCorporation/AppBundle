<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Adjuntos;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdjuntosType extends AbstractType
{
	protected $em, $translator;
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
	        ->add ('nombre', 'text', ['label' => $this->translator->trans ('adjuntos.form.name'),
		                              'max_length' => 10])
	        ->add ('alt', 'text', ['label' => $this->translator->trans ('adjuntos.form.alt'),
		                              'max_length' => 150])
            ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('adjuntos.form.description'),
	                                      'max_length' => 150])
            ->add('archivo','file', ['label' => $this->translator->trans ('adjuntos.form.file')])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('adjuntos.form.status'),
		        'choices' => [TRUE => $this->translator->trans ('form.active'),
			        FALSE => $this->translator->trans ('form.desactive')]]);
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\Adjuntos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_adjuntos';
    }

	public function newEntity()
	{
		$adjunto = new Adjuntos();

		return $adjunto;
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
				$this->translator->trans ('adjuntos.list.file') => 'file',
			];

	}
}
