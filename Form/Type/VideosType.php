<?php

namespace Destiny\AppBundle\Form\Type;

use Destiny\AppBundle\Entity\Videos;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class VideosType extends AbstractType
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
	        ->add ('nombre', 'text', ['label' => $this->translator->trans ('videos.form.name'),
		        'max_length' => 10])
	        ->add ('alt', 'text', ['label' => $this->translator->trans ('videos.form.alt'),
		        'max_length' => 150])
	        ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('videos.form.description'),
		                                      'max_length' => 150,
	                                         ])
            ->add('url', 'text', ['label' => $this->translator->trans ('videos.form.url')])
	        ->add ('estado', 'choice', ['label' => $this->translator->trans ('videos.form.status'),
		        'choices' => [TRUE => $this->translator->trans ('form.active'),
			        FALSE => $this->translator->trans ('form.desactive')]]);
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\Videos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_videos';
    }

	public function newEntity()
	{
		$videos = new Videos();

		return $videos;
	}

	public function isDeletable ($videos)
	{

		return TRUE;
	}

	public function isChangeable ($videos)
	{

		return TRUE;
	}
}
