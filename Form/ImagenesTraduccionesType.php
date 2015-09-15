<?php

namespace Destiny\AppBundle\Form;

use Destiny\AppBundle\Entity\Imagenes;
use Destiny\AppBundle\Entity\ImagenesTraducciones;
use Doctrine\ORM\EntityManager;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagenesTraduccionesType extends AbstractType
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
		    ->add ('nombre', 'text', ['label' => $this->translator->trans ('imagenes.form.name'),
			    'max_length' => 100])
		    ->add ('alt', 'text', ['label' => $this->translator->trans ('imagenes.form.alt'),
			    'max_length' => 150])
		    ->add('descripcion', 'text', ['label' => $this->translator->trans ('imagenes.form.description'),
			    'max_length' => 150])
		    ->add('archivo','file', ['required' => false,'label' => $this->translator->trans ('imagenes.form.file')])

	    ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\ImagenesTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_imagenes_traducciones';
    }

	public function newEntity()
	{
		$imagen = new ImagenesTraducciones();

		return $imagen;
	}

}
