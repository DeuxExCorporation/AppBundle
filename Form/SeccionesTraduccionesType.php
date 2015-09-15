<?php

namespace Destiny\AppBundle\Form;

use Destiny\AppBundle\Entity\Secciones;
use Destiny\AppBundle\Entity\SeccionesTraducciones;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class SeccionesTraduccionesType extends AbstractType
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
            ->add('etiquetaMenu', 'text', ['label' => $this->translator->trans ('secciones.form.tagMenu')])
            ->add('url', 'text', ['label' => $this->translator->trans ('secciones.form.url')])
            ->add('tituloWeb', 'text', ['label' => $this->translator->trans ('secciones.form.webTitle')])
            ->add('tituloSeccion', 'text', ['label' => $this->translator->trans ('secciones.form.sectionTitle')])
            ->add('tituloSeo', 'text', ['label' => $this->translator->trans ('secciones.form.seoTitle')])
            ->add('descripcionSeo', 'text', ['label' => $this->translator->trans ('secciones.form.seoDescription')])
        ;

        if ($options['data']->getCanonica()->getPortada()== true)
        {
            $builder->remove('url');
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\SeccionesTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_secciones_traducciones';
    }

	public function newEntity()
	{
		return new SeccionesTraducciones();
	}


}
