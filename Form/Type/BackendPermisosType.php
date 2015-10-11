<?php

namespace Destiny\AppBundle\Form\Type;


use Destiny\AppBundle\Entity\BackendPermisos;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class IdiomasType
 * @package Destiny\AppBundle\Form
 *

 */
class BackendPermisosType extends AbstractType
{
	protected $em, $translator;


	public function __construct (EntityManager $em, Translator $translator)
	{
		$this->em = $em;
		$this->translator = $translator;

	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm (FormBuilderInterface $builder, array $options)
	{
		$builder
			->add ('estado', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.status'),
				'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
					FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

			->add ('crear', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.create'),
				'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
					          FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

			->add ('editar', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.edit'),
				   					    'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
								 				      FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

			->add ('borrar', 'choice', ['label' => $this->translator->trans ('BackendPermisos.form.delete'),
				   						'choices' => [TRUE => $this->translator->trans ('BackendPermisos.form.yes'),
							     					  FALSE => $this->translator->trans ('BackendPermisos.form.no')]])

            ->add('grupos', 'entity', array(
                'class' => 'DestinyAppBundle:RolesUsuarios',
                'label' => $this->translator->trans ('BackendPermisos.form.grups'),
                'required' => false,
                'expanded' => false,
                'multiple' => true,
                'choice_label' => 'nombre',
                'query_builder' => function(EntityRepository $er)  {

                    return $er->createQueryBuilder('g')
                        ->orderBy('g.grupo');}))
			;

	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults (array (
			'data_class' => 'Destiny\AppBundle\Entity\BackendPermisos'
		));
	}

	/**
	 * @return string
	 */
	public function getName ()
	{
		return 'destiny_appbundle_permisos';
	}

    public function newEntity ()
    {
        return new BackendPermisos();
    }


	public function isDeletable ()
	{
		return false;
	}

	public function isChangeable ($entidad)
	{

		return TRUE;
	}

	public function cantCreate ()
	{

		return TRUE;
	}
    public function postChange( $entidad)
    {

        if ($entidad->getEstado() === false)
        {
            $entidad->setEstado(false)->setBorrar(false)->setCrear(false)->setEditar(false);


            foreach ($entidad->getGrupos()->getValues() as $grupo)
            {
                $entidad->removeGrupo($grupo);
                $this->em->persist($entidad);
            }
        }

        $this->em->flush();
    }

	public function postEdit( $entidad)
	{
        if ($entidad->getGrupos()->count() === 0 || $entidad->getEstado() === false)
        {
            $entidad->setEstado(false)->setBorrar(false)->setCrear(false)->setEditar(false);
        }

		$this->blockeator($entidad);
	}

	public function blockeator( $entidad)
    {

        $seccion = $this->em->getRepository('DestinyAppBundle:BackendSecciones')->findOneByDestino($entidad->getEntidad());

        $seccion->setEstado($entidad->getEstado());


        if ($seccion->getPermisos()->count() === 0 )
        {

            $this->firstSave($entidad, $seccion);

        }else
        {

            $this->verification($entidad, $seccion);
        }

        $this->em->flush();

    }

    protected function firstSave($entidad, $seccion)
    {
        foreach ($entidad->getGrupos()->getValues() as $grupo)
        {
            $this->saveGroup($entidad,$seccion,$grupo);
        }
    }

    protected function verification($entidad, $seccion)
    {
        foreach ($entidad->getGrupos()->getValues() as $grupo)
        {
            foreach ($seccion->getPermisos()->getValues() as $roles)
            {

                $this->removeGroup($entidad,$seccion);
                $this->saveGroup($entidad,$seccion);

            }
        }
    }

    protected function saveGroup($entidad, $seccion)
    {

        foreach ($entidad->getGrupos() as $grupo)
        {

            $seccion->addPermisos($grupo);
            $this->em->persist($seccion);
        }

        $this->em->flush();

    }

    protected function removeGroup($entidad, $seccion)
    {
        foreach ($entidad->getGrupos() as $grupo)
        {

            $seccion->removePermiso($grupo);
            $this->em->persist($seccion);
        }

        $this->em->flush();
    }

}
