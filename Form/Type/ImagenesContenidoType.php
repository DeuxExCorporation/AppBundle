<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\NoticiasContenido;
use Destiny\AppBundle\Entity\SeccionesContenido;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class ImagenesContenidoType extends AbstractType
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
	        ->add('imagenes', 'entity', array(
		        'class' => 'DestinyAppBundle:Imagenes',
		        'data_class' => 'Destiny\AppBundle\Entity\Imagenes',
		        'required' => true,
		        'expanded' => true,
		        'choice_label' => 'webPath',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{

	}

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_seccionescontenido';
    }

	public function newEntity($seccion, $type)
	{

		$contenido = ($type === 'noticias') ? new NoticiasContenido() : new SeccionesContenido();
		$seccion = $this->em->getRepository('DestinyAppBundle:'.ucfirst($type))->findOneBySlug($seccion);

		$contenido->setSeccion($seccion);

		$posicion = $seccion->getContenidos()->count();
		$contenido->setPosicion($posicion +1);


		return $contenido;
	}

	public function isDeletable ($imagen)
	{

		return TRUE;
	}

	public function isChangeable ($imagen)
	{

		return TRUE;
	}

}
