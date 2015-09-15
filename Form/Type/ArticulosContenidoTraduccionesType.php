<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Articulos;
use Destiny\AppBundle\Entity\ArticulosTraducciones;
use Destiny\AppBundle\Entity\NoticiasContenido;
use Destiny\AppBundle\Entity\SeccionesContenido;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticulosContenidoTraduccionesType extends AbstractType
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
	        ->add ('titulo', 'text', ['label' => $this->translator->trans ('articulosContenido.form.title'),
		        'max_length' => 150])
	        ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('articulosContenido.form.description'),
		        'max_length' => 150,
	        ])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\ArticulosTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_articulos_traducciones';
    }

	public function newEntity()
	{
		$articulo = new ArticulosTraducciones();


		return $articulo;
	}


}
