<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Noticias;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class NoticiasType extends AbstractType
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
            ->add('titulo', 'text', ['label' => $this->translator->trans ('noticias.form.title')])
            ->add('tituloSeo', 'text', ['label' => $this->translator->trans ('noticias.form.seoTitle')])
            ->add('descripcionSeo', 'text', ['label' => $this->translator->trans ('noticias.form.seoDescription')])
	        ->add('categorias','entity',['label' => $this->translator->trans('noticias.form.categoria'),
		        'class'         => 'DestinyAppBundle:NoticiasCategorias',
		        'required'      => false,
		        'multiple'      => true,
		        ])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('noticias.form.status'),
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
            'data_class' => 'Destiny\AppBundle\Entity\Noticias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_secciones';
    }

	public function newEntity ($menu = null)
	{

		$noticia = new Noticias();


		if (!is_null($menu))$noticia->setTipo($this->em->getRepository('DestinyAppBundle:SeccionesTipo')->findOneBySlug('noticias'));

		return $noticia;
	}

	public function isDeletable ($seccion)
	{

		return TRUE;
	}

	public function isChangeable ($seccion)
	{

		return TRUE;
	}

	public function listButton()
	{
		return ['action'=> 'listContentBackend',
		        'tag'   => $this->translator->trans('secciones.list.contenido'),
				'type'  => 'noticias',
		        'class' => 'btn btn-success'];
	}

}
