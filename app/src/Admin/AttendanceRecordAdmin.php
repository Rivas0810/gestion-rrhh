<?php

namespace App\Admin;

use App\Entity\AttendanceRecord;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormError;   
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
                    'edit' => ['link_parameters' => ['full' => true]],
                    ]
                    ]);
            ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $isEdit = $this->isCurrentRoute('edit');

        $form
            ->add('employee', null, ['label'=> 'Empleado', 'required' => true, 'disabled'=> $isEdit])
            ->add('entry_time', null, ['label'=> 'Hora de Entrada', 'disabled'=> $isEdit])
            ->add('exit_time', null, ['label'=> 'Hora de Salida',])
            ;
    }

    public function preValidate($object): void
    {
        $name = trim((string) $this->getForm()->get('employee')->getData());
        if ($name === '' ) {
            $this->getForm()->get('employee')->addError(new FormError('Hubo un error con el campo empleado.'));
        }        

        $entry_time = $this->getForm()->get('entry_time')->getData();
        if ($entry_time == '' ) {
            $this->getForm()->get('entry_time')->addError(new FormError('Hubo un error con el campo hora de entrada.'));
        }
    }
}
