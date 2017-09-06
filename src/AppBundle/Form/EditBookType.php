<?php


namespace AppBundle\Form;


use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EditBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('description')
            ->add('categorycategory', EntityType::class, [
                'placeholder' => 'Choose a Category',
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
            ])
            ->add('authorsauthors', EntityType::class, [
                'placeholder' => 'Choose a Author',
                'class' => Authors::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Books::class,
        ));
    }
}