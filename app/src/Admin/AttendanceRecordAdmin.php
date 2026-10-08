<?php

namespace App\Admin;

use App\Entity\AttendanceRecord;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class AttendanceRecordAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', null, ['label'=> 'ID',])
            ->add('employee', null, ['label'=> 'Empleado',])
            ->add('entry_time', null, ['label'=> 'Hora de Entrada',])
            ->add('exit_time', null, ['label'=> 'Hora de Salida',])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'label'=> 'Acciones',
                'actions' => [  
                    'show' => [],
                    ]
                    ]);
            ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('employee', null, ['label'=> 'Empleado',])
            ->add('entry_time', null, ['label'=> 'Hora de Entrada',])
            ->add('exit_time', null, ['label'=> 'Hora de Salida',])
            ;
    }
}
