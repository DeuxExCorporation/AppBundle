<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\NoticiasTraducciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class NoticiasTraduccionesType extends AbstractType
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
            ->add('titulo', 'text', ['label' => $this->translator->trans ('noticias.form.title')])
            ->add('tituloSeo', 'text', ['label' => $this->translator->trans ('noticias.form.seoTitle')])
            ->add('descripcionSeo', 'text', ['label' => $this->translator->trans ('noticias.form.seoDescription')])
            ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('articulosContenido.form.description')])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\NoticiasTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_secciones_traducciones';
    }

	public function newEntity ()
	{

		$noticia = new NoticiasTraducciones();



		return $noticia;
	}


}
