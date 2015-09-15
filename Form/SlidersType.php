<?php

namespace Destiny\AppBundle\Form;

use Destiny\AppBundle\Entity\Sliders;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlidersType extends AbstractType
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
	        ->add ('nombre', 'text', ['label' => $this->translator->trans ('sliders.form.name'),
		        'max_length' => 10])
	        ->add('descripcion', 'text', ['label' => $this->translator->trans ('sliders.form.description'),
		        'max_length' => 150])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('sliders.form.status'),
		        'choices' => [TRUE => $this->translator->trans ('form.active'),
			        FALSE => $this->translator->trans ('form.desactive')]])
	        ->add('group', 'entity', array(
		        'class' => 'DestinyAppBundle:Imagenes',
		        'label' => $this->translator->trans ('sliders.form.group'),
		        'required' => true,
		        'expanded' => true,
		        'multiple' => true,

		        'choice_label' => 'webPath',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\Sliders',
	        'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_sliders';
    }

	public function newEntity ()
	{
		$slider = new Sliders();

		return $slider;
	}

	public function isDeletable ($slider)
	{

		return TRUE;
	}

	public function isChangeable ($slider)
	{

		return TRUE;
	}

	public function listElements ()
	{
		return null;
	}
}
