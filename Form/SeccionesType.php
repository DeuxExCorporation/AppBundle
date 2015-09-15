<?php

namespace Destiny\AppBundle\Form;

use Destiny\AppBundle\Entity\Secciones;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class SeccionesType extends AbstractType
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
		$menu = (method_exists($options['data'],'getMenu') ? $options['data']->getMenu() : $options['data']->getCanonica()->getMenu());
        $seccion = (method_exists($options['data'],'getSlug') ? $options['data']->getSlug() : $options['data']->getCanonica()->getSlug());




        $builder
            ->add('nombre', 'text', ['label' => $this->translator->trans ('secciones.form.name')])
            ->add('url', 'text', ['label' => $this->translator->trans ('secciones.form.url')])
            ->add('etiquetaMenu', 'text', ['label' => $this->translator->trans ('secciones.form.tagMenu')])
            ->add('tituloWeb', 'text', ['label' => $this->translator->trans ('secciones.form.webTitle')])
            ->add('tituloSeccion', 'text', ['label' => $this->translator->trans ('secciones.form.sectionTitle')])
            ->add('tituloSeo', 'text', ['label' => $this->translator->trans ('secciones.form.seoTitle')])
            ->add('descripcionSeo', 'text', ['label' => $this->translator->trans ('secciones.form.seoDescription')])
            ->add('padre','entity',['label' => $this->translator->trans('secciones.form.padre'),
	            'class'         => 'DestinyAppBundle:Secciones',
	            'required'      => false,
	            'query_builder' => function(EntityRepository $er) use ($menu,$seccion) {

		            return $er->createQueryBuilder('s')
			            ->innerJoin('s.menu','m')
			            ->where('m.slug = :tipo')
			            ->andWhere('m.haveSubsecciones = :sub')
			            ->andWhere('s.slug != :seccionActual')
			            ->setParameters(['tipo' => $menu->getSlug(),
			                             'seccionActual' => $seccion,
			                             'sub'  => true])
			            ->orderBy('s.slug');



	            }])

	        ->add('tipo','entity',['label' => $this->translator->trans('secciones.form.tipo'),
		        'class'         => 'DestinyAppBundle:SeccionesTipo',
		        'required'      => true,
		        'query_builder' => function(EntityRepository $er) {
			        return $er->createQueryBuilder('t')
				        ->orderBy('t.slug');

		        } ])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('form.status'),
		        'choices' => [TRUE => $this->translator->trans ('form.active'),
			        FALSE => $this->translator->trans ('form.desactive')]])
        ;

	    if (method_exists($options['data'],'getPortada'))
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
            'data_class' => 'Destiny\AppBundle\Entity\Secciones'
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

		$seccion = new Secciones();

		if ($menu != null)
		{
			$secciones = $this->em->getRepository('DestinyAppBundle:Secciones')
					->getSeccionesBackend($menu);

			$seccion->setMenu($this->em->getRepository('DestinyAppBundle:Menus')->findOneBySlug($menu));
			$posicion = count($secciones) +1;
			$seccion->setPosicion($posicion);
		}

		return $seccion;
	}

	public function isDeletable ($seccion)
	{

		return TRUE;
	}

	public function isChangeable ($seccion)
	{

		return TRUE;
	}


	public function groups ($tipo = null )
	{

			$group = $this->em->getRepository('DestinyAppBundle:Menus')->findAll();

			return $group;


	}

	public function listElements ()
	{
		return
			[
				$this->translator->trans ('secciones.list.changePosition') => null,
			];

	}

	public function postEdit($seccion)
	{
		$seccionesMenu = $seccion->getMenu()->getSecciones()->getValues();

		if ($seccion->getPadre() != null)
		{
			$secciones = $seccion->getPadre()->getSubsecciones();

			$i = 1;
			foreach ($secciones as $posicionActual)
			{
				$posicionActual->setPosicion($i);
				$i++;
				$this->em->persist($posicionActual);
			}
		}


		$i=1;
		foreach ($seccionesMenu as $seccion)
		{
			if(is_null($seccion->getPadre()))
			{
				$seccion->setPosicion($i);
				$this->em->persist($seccion);
				$i++;
			}

		}

		$this->em->flush();
	}

	public function postCreate($seccion)
	{
		$seccionesMenu = $seccion->getMenu()->getSecciones()->getValues();



		if ($seccion->getPadre() != null)
		{
			$secciones = $seccion->getPadre()->getSubsecciones();

			$i = 1;
			foreach ($secciones as $posicionActual)
			{
				$posicionActual->setPosicion($i);
				$i++;
				$this->em->persist($posicionActual);
			}
		}


		$i=1;
		foreach ($seccionesMenu as $seccion)
		{
			if(is_null($seccion->getPadre()))
			{
				$seccion->setPosicion($i);
				$this->em->persist($seccion);
				$i++;
			}

		}

		$this->em->flush();
	}


	public function postDelete($seccion)
	{
		$seccionesMenu = $seccion->getMenu()->getSecciones()->getValues();

		foreach ($seccionesMenu as $seccionMenu)
		{
			if ($seccionMenu->getPosicion() > $seccion->getPosicion())
			{
				$posicion = $seccionMenu->getPosicion();
				$posicion--;
				$seccionMenu->setPosicion($posicion);
				$this->em->persist ($seccionMenu);

			}
		}

		$this->em->flush ();


	}

	public function listButton()
	{
		return ['action'=> 'listContentBackend',
		        'tag'   => $this->translator->trans('secciones.list.contenido'),
				'type'  => 'secciones',
		        'class' => 'btn btn-success'];
	}

}
