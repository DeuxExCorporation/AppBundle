<?php

namespace Destiny\AppBundle\Form;

use Destiny\AppBundle\Entity\NoticiasContenido;
use Destiny\AppBundle\Entity\SeccionesContenido;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class VideosContenidoType extends AbstractType
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
            ->add('videos','entity', array(
			    'class' => 'DestinyAppBundle:Videos',
			    'label' => $this->translator->trans ('videosContenido.form.name'),
			    'required' => true,))
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
