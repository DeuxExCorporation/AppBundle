<?php

namespace Destiny\AppBundle\Form;


use Destiny\AppBundle\Entity\SeccionesContenido;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SeccionesContenidoType extends AbstractType
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

    }

    public function newEntity()
    {
        return new SeccionesContenido();
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\SeccionesContenido'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_seccionescontenido';
    }

	public function isDeletable ($seccion)
	{

		return TRUE;
	}

	public function isChangeable ($seccion)
	{

		return TRUE;
	}

	public function postDelete($seccion)
	{


		$contenidoSecciones = $seccion->getSeccion()->getContenidos()->getValues();

		foreach ($contenidoSecciones as $contenido)
		{
			if ($contenido->getPosicion() > $seccion->getPosicion())
			{
				$posicion = $contenido->getPosicion();
				$posicion--;
				$contenido->setPosicion($posicion);
				$this->em->persist ($contenido);

			}
		}

		$this->em->flush ();


	}

    public function listElements ()
    {
        return
            [
                $this->translator->trans ('secciones.list.changePosition') => null,
            ];

    }
}
