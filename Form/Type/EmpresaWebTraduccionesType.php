<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\EmpresaWeb;
use Destiny\AppBundle\Entity\EmpresaWebTraducciones;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class EmpresaWebTraduccionesType extends AbstractType
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
            ->add('slogan','text',['label' =>$this->translator->trans('empresa.form.slogan') ])
	        ->add('mensajeBloqueo','textarea',['label' =>$this->translator->trans('empresa.form.mensajeBloqueo') ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\EmpresaWebTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_empresaweb_traduccion';
    }

	public function newEntity ()
	{
		$empresa = new EmpresaWebTraducciones();

		return $empresa;
	}

}
