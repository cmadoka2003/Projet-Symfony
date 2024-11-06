<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

class CollectionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')->setAttributes(["class" => "form-group"])
            ->add('titre', Types\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir le titre"]),
                    new Assert\Length(["min" => 3, "max" => 100, "minMessage" => "titre trop court", "maxMessage" => "titre trop long"])
                ]
            ])
            ->add('description', Types\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir la description"]),
                    new Assert\Length(["max" => 500, "maxMessage" => "description trop long"])
                ]
            ])
            ->add("isPublic", Types\CheckboxType::class)
            ->add('cover', Types\FileType::class, [
                'data_class' => null,
                'required' => false,
                'mapped'=>false,
                'constraints' => [
                    new Assert\File(["extensions" => ["jpg", "png"], 'mimeTypesMessage' => 'format jpg/png seulement',])
                ]
            ])
            ->add('tags', Types\TextType::class, [
                'mapped'=>false,
                'constraints' => [
                    new Assert\Length(["max" => 500, "maxMessage" => "description trop long"])
                ]
            ])
            ->add('categorie', Types\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir la categorie"]),
                    new Assert\Length(["max" => 50, "maxMessage" => "categorie trop long"])
                ]
            ])
            ->add('Submit', Types\SubmitType::class);

        $builder->get('titre')->setRequired(false);
        $builder->get('cover')->setRequired(false);
        $builder->get('categorie')->setRequired(false);
        $builder->get('description')->setRequired(false);
        $builder->get('isPublic')->setRequired(false);
        $builder->get('tags')->setRequired(false);
    }
}