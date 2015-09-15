<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\NoticiasCategorias;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Translator;

class NoticiasCategoriasType extends AbstractType
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
	        ->add('nombre', 'text', ['label' => $this->translator->trans ('noticiasCategorias.form.name')])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('noticiasCategorias.form.status'),
		        'choices' => [TRUE => $this->translator->trans ('form.active'),
			        FALSE => $this->translator->trans ('form.desactive')]])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\NoticiasCategorias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_noticiascategorias';
    }

	public function newEntity ()
	{

		$categorias = new NoticiasCategorias();


		return $categorias;
	}


	public function isDeletable ($categorias)
	{

		return TRUE;
	}

	public function isChangeable ($categorias)
	{

		return TRUE;
	}

}
