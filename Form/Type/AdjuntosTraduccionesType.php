<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Adjuntos;
use Destiny\AppBundle\Entity\AdjuntosTraducciones;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdjuntosTraduccionesType extends AbstractType
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
	        ->add ('nombre', 'text', ['label' => $this->translator->trans ('adjuntos.form.name'),
		        'max_length' => 100])
	        ->add ('alt', 'text', ['label' => $this->translator->trans ('adjuntos.form.alt'),
		                              'max_length' => 150])
            ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('adjuntos.form.description'),
	                                      'max_length' => 150])
            ->add('archivo','file', ['required' => false,'label' => $this->translator->trans ('adjuntos.form.file')])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\AdjuntosTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_adjuntos_traducciones';
    }

	public function newEntity()
	{
		$adjunto = new AdjuntosTraducciones();

		return $adjunto;
	}
}
