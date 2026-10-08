<?php

namespace App\Admin;

use App\Entity\Department;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormError;   


final class DepartmentAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', null, ['label'=> 'ID',])
            ->add('name', null, ['label'=> 'Nombre',])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'label'=> 'Acciones',
                'actions' => [  
                    'show' => [],
                    'edit' => ['link_parameters' => ['full' => true]],
                    ]
                    ]);
            ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', null, [
                'required' => true,
                'label'=> 'Departamento',
                'help' => 'Departamento al cual pertenece',
            ]);
    }
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('name', null, [
                'label' => 'Departamento',
            ])
            ->add('employeesList', null, [
                'label' => 'Empleados',
            ]);
    }
    public function preValidate($object): void
    {
        $name = trim((string) $this->getForm()->get('name')->getData());
        if ($name === '' ) {
            $this->getForm()->get('name')->addError(new FormError('Hubo un error con el campo nombre.'));
        }
    }

}
