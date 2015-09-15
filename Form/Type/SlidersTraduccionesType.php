<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Sliders;
use Destiny\AppBundle\Entity\SlidersTraducciones;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlidersTraduccionesType extends AbstractType
{
	protected $translator;


	public function __construct (Translator $translator)
	{
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
		        'max_length' => 100])
	        ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('sliders.form.description'),
		        'max_length' => 150])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\SlidersTraducciones',
	        'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_sliders_traduccion';
    }

    public function newEntity()
    {
        $slider = new SlidersTraducciones();

        return $slider;
    }
}
