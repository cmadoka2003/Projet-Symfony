<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\Validator\Constraints as Assert;

class PostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add('titre', Types\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir le titre"]),
                    new Assert\Length(["min" => 3, "max" => 100, "minMessage" => "titre trop court", "maxMessage" => "titre trop long"])
                ]
            ])
            ->add('description', Types\TextType::class, [
                'constraints' => [
                    new Assert\Length(["max" => 1000, "maxMessage" => "description trop long"])
                ]
            ])
            ->add("isPublic", Types\CheckboxType::class)
            ->add('image', Types\FileType::class, [
                'data_class' => null,
                'required' => false,
                'mapped'=>false,
                'constraints' => [
                    new Assert\File(["extensions" => ["jpg", "png"], 'mimeTypesMessage' => 'format jpg/png seulement',])
                ]
            ])
            ->add('Submit', Types\SubmitType::class);

        $builder->get('titre')->setRequired(false);
        $builder->get('description')->setRequired(false);
        $builder->get('isPublic')->setRequired(false);
    }
}