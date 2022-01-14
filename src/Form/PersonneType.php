<?php
//relation job personne a été supprimer , il faut la recreér
namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Profile;
use App\Entity\Personne;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('name')
            ->add('age')
            ->add('created_at')
            ->add('update_at')
            ->add('profile',EntityType::class,[
                'expanded'=>true,
                'class'=>Profile::class,
                'multiple'=>false
            ])
            ->add('hobby',EntityType::class,[
                'expanded'=>false,
                'class'=>Hobby::class,
                'multiple'=>true,
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('h')
                              ->orderBy('h.designation','ASC');
                },
            ])
            ->add('job')

            ->add('photo', FileType::class, [
                'label' => 'votre image de profile (Des fichiers images uniquement)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/jpg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'veuillez uploader une image valide.',
                    ])
                ],
            ])
            ->add('editer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
