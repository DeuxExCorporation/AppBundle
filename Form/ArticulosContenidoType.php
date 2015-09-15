<?php

namespace Destiny\AppBundle\Form;

use Destiny\AppBundle\Entity\Articulos;
use Destiny\AppBundle\Entity\NoticiasContenido;
use Destiny\AppBundle\Entity\SeccionesContenido;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticulosContenidoType extends AbstractType
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
            'data_class' => 'Destiny\AppBundle\Entity\Articulos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_articulos';
    }

	public function newEntity($seccion,$type)
	{
		$articulo = new Articulos();

		$seccion = $this->em->getRepository('DestinyAppBundle:'.ucfirst($type))->findOneBySlug($seccion);

		if ($type === 'noticias'){
			$articulo->setNoticia($seccion);
		}else{
			$articulo->setSeccion($seccion);

		}
		$articulo->setEstado(true);

		$posicion = $seccion->getContenidos()->count();
		$articulo->setPosicion($posicion +1);


		return $articulo;
	}

	public function postCreate($articulo,$seccion, $type)
	{


		$contenido = ($type === 'noticias') ? new NoticiasContenido() : new SeccionesContenido();
		$contenido->setSeccion($seccion);

		$posicion = $seccion->getContenidos()->count();
		$contenido->setPosicion($posicion +1);
		$contenido->setEstado(true);
		$contenido->setChangablePostion(true);

		$contenido->setArticulos($articulo);

		$this->em->persist($contenido);
		$this->em->flush();

		return $articulo;

	}


	public function isDeletable ($empresa)
	{
		return TRUE;

	}

	public function isChangeable ($empresa)
	{

		return TRUE;
	}
}
