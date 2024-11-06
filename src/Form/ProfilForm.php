<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Types;
use Symfony\Component\Validator\Constraints as Assert;

class ProfilForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST')
            ->add('avatar', Types\FileType::class, [
                'data_class' => null,
                'required' => false,
                'mapped'=>false,
                'constraints' => [
                    new Assert\File(["extensions" => ["jpg", "png"], 'mimeTypesMessage' => 'format jpg/png seulement',])
                ]
            ])
            ->add('pseudo', Types\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir le pseudo"]),
                    new Assert\Length(["min" => 6, "max" => 50, "minMessage" => "pseudo trop court", "maxMessage" => "pseudo trop long"])
                ]
            ])
            ->add('emploi', Types\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir l'emploi"]),
                    new Assert\Length(["min" => 6, "max" => 50, "minMessage" => "nom de l'emploi trop court", "maxMessage" => "nom de l'emploi trop long"])
                ]
            ])
            ->add('description', Types\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir la description"]),
                    new Assert\Length(["max" => 500, "maxMessage" => "description trop long"])
                ]
            ])
            ->add('phone', Types\TelType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir le numéro de téléphone"]),
                    new Assert\Length(["min" => 10, "minMessage" => "numéro de téléphone trop court"])
                ]
            ])
            ->add('siteURL', Types\UrlType::class, [
                'constraints' => [
                    new Assert\NotBlank(["message" => "vous devez remplir le champ"]),
                ]
            ])
            ->add('Submit', Types\SubmitType::class);

        $builder->get('avatar')->setRequired(false);
        $builder->get('pseudo')->setRequired(false);
        $builder->get('emploi')->setRequired(false);
        $builder->get('description')->setRequired(false);
    }
}