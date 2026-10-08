<?php

namespace App\Admin;

use App\Entity\Department;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

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
}
