<?php

namespace Destiny\AppBundle\Form\Type;


use Destiny\AppBundle\Entity\VideosTraducciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class VideosTraduccionesType extends AbstractType
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
	        ->add ('nombre', 'text', ['label' => $this->translator->trans ('videos.form.name'),
		        'max_length' => 10])
	        ->add ('alt', 'text', ['label' => $this->translator->trans ('videos.form.alt'),
		        'max_length' => 150])
	        ->add('descripcion', 'textarea', ['label' => $this->translator->trans ('videos.form.description'),
		                                      'max_length' => 150,
	                                         ])
            ->add('url', 'text', ['required' => false,'label' => $this->translator->trans ('videos.form.url')])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destiny\AppBundle\Entity\VideosTraducciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destiny_appbundle_videos_traducciones';
    }

	public function newEntity()
	{
		$videos = new VideosTraducciones();

		return $videos;
	}

}
