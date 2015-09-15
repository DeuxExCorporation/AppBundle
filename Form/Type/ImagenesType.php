<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Imagenes;
use Doctrine\ORM\EntityManager;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagenesType extends AbstractType
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
		    ->add ('nombre', 'text', ['label' => $this->translator->trans ('imagenes.form.name'),
			    'max_length' => 10])
		    ->add ('alt', 'text', ['label' => $this->translator->trans ('imagenes.form.alt'),
			    'max_length' => 150])
		    ->add('descripcion', 'text', ['label' => $this->translator->trans ('imagenes.form.description'),
			    'max_length' => 150])
		    ->add('archivo','file', ['label' => $this->translator->trans ('imagenes.form.file')])
		    ->add ('estado', 'choice', ['label' => $this->translator->trans ('imagenes.form.status'),
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
            'data_class' => 'Destiny\AppBundle\Entity\Imagenes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_imagenes';
    }

	public function newEntity()
	{
		$imagen = new Imagenes();

		return $imagen;
	}

	public function isDeletable ($imagen)
	{

		return TRUE;
	}

	public function isChangeable ($imagen)
	{

		return TRUE;
	}


}
