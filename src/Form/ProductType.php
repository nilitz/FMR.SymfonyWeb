<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('max_production')
            ->add('max_user')
            ->add('image')
            ->add('description')
            ->add('production_time', ChoiceType::class, [
                'choices' => $this->getPeriods()
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    private function getPeriods()
    {
        $periods = Product::PERIOD;
        $output = [];
        foreach ($periods as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }

}
