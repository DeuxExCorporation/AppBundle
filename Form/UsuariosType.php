<?php

namespace Destiny\AppBundle\Form;



use Destiny\AppBundle\Entity\Usuarios;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class UserType
 * @package Destiny\AppBundle\Form
 *

 */
class UsuariosType extends AbstractType
{
	protected $em, $translator, $container;

	public function __construct (EntityManager $em, Translator $translator, Container $container)
	{
		$this->em = $em;
		$this->translator = $translator;
		$this->container = $container;

	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	public function buildForm (FormBuilderInterface $builder, array $options)
	{
		$builder
			->add ('email', 'email', ['label' => $this->translator->trans ('usuarios.form.email'),
									  'max_length' => 100])

			->add('username','text',['label' => $this->translator->trans ('usuarios.form.username')])
			->add('plainPassword','password',['label' => $this->translator->trans ('usuarios.form.password')])
			;
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults (array (
				'data_class' => 'Destiny\AppBundle\Entity\Usuarios'
		));
	}

	/**
	 * @return string
	 */
	public function getName ()
	{
		return 'destiny_appbundle_usuarios';
	}

	public function newEntity ($grupo = null)
	{
		$usuario = new Usuarios();

		switch ($grupo){

			case $grupo ==='admin':
				$usuario->setRoles(['ROLE_ROOT']);

			break;

			case $grupo ==='normal':
				$usuario->setRoles(['ROLE_NORMALUSER']);

			break;

            case $grupo ==='gestor':
                $usuario->setRoles(['ROLE_GESTOR']);

                break;
		}



		return $usuario;
	}

	public function isDeletable ($usuario)
	{
		if (in_array('ROLE_ROOT',$usuario->getRoles()))
		{
			return false;
		}

		return TRUE;
	}


	public function isChangeable ($usuario)
	{

		if (in_array('ROLE_ROOT',$usuario->getRoles()))
		{
			return false;
		}

		return TRUE;
	}


	public function groups ()
	{
		return ['ROLE_NORMALUSER' =>['nombre'=>'Normal',
									 'slug'  =>'normal',
									 'rol'   => 'ROLE_NORMALUSER'],
				'ROLE_ROOT'       =>['nombre'=>'Administrador',
							         'slug'  =>'admin',
									 'rol'   => 'ROLE_ROOT'],
                'ROLE_GESTOR'       =>['nombre'=>'Gestores',
                                        'slug'  =>'gestor',
                                        'rol'   => 'ROLE_GESTOR']];
	}

	public function postEdit ($usuario)
	{
		$this->container->get ('email')->enviarEmailUsuario ('modificacion-usuario', $usuario);
	}

	public function postCreate ($usuario)
	{
		$usuario->setEstado (FALSE);
		$this->container->get ('email')->enviarEmailUsuario ('nuevo-usuario', $usuario);

		return $usuario;
	}


	public function listElements ()
	{
		return
			[
				$this->translator->trans ('usuarios.list.email') => 'email',
			];

	}
}
