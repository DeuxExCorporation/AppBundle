<?php

namespace Destiny\AppBundle\Form;

use Destiny\AppBundle\Entity\NoticiasCategorias;
use Destiny\AppBundle\Entity\NoticiasCategoriasTraducciones;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Translator;

class NoticiasCategoriasTraduccionesType extends AbstractType
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
	        ->add('nombre', 'text', ['label' => $this->translator->trans ('noticiasCategorias.form.name')])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\NoticiasCategoriasTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_noticiascategorias_traducciones';
    }

	public function newEntity ()
	{

		$categorias = new NoticiasCategoriasTraducciones();


		return $categorias
			;
	}




}
