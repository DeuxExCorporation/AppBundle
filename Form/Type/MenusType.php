<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Menus;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenusType extends AbstractType
{
	protected $em, $translator;


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
	        ->add ('nombre', 'text', ['label' => $this->translator->trans ('menus.form.name'),
		                              'max_length' => 10])
            ->add ('nombre', 'text', ['label' => $this->translator->trans ('menus.form.name'),
                'max_length' => 10])
            ->add('limite','integer',['label' => $this->translator->trans('menus.form.limite'),'attr'=>['min' => 0]])
	        ->add ('haveSubsecciones', 'choice', ['label' => $this->translator->trans ('menus.form.submenus'),
								          'choices' => [TRUE => $this->translator->trans ('menus.form.yes'),
										                FALSE => $this->translator->trans ('menus.form.not')]])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('form.status'),
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
            'data_class' => 'Destiny\AppBundle\Entity\Menus'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_menus';
    }

	public function newEntity ()
	{
		$menu = new Menus();

		return $menu;
	}

	public function isDeletable ($menu)
	{

		return TRUE;
	}

	public function isChangeable ($menu)
	{

		return TRUE;
	}



}
