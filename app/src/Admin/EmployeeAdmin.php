<?php

namespace App\Admin;

use App\Entity\Employee;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use App\Controller\Admin\EmployeeAdminController;
use Symfony\Component\Form\FormError;   
use Sonata\AdminBundle\Show\ShowMapper;

final class EmployeeAdmin extends AbstractAdmin
{
    protected $baseControllerName = EmployeeAdminController::class;

    protected function configureListFields(ListMapper $list): void
    {
        $list
            // ->addIdentifier('id', null, ['label'=> 'ID',])
            ->addIdentifier('employee_identifier', null, ['label'=> 'ID de empleado',])
            ->add('name', null, ['label'=> 'Nombre',])
            ->add('email', null, ['label'=> 'Correo Electronico',])
            ->add('phone', null, ['label'=> 'Telefono',])
            ->add('department', null, ['label'=> 'Departamento',])
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
                'label'=> 'Nombre',
                'attr' => ['placeholder' => 'Nombre completo del empleado'],
            ])
            ->add('employee_identifier', null, [
                'required' => true,
                'label'=> 'ID de empleado',
                'attr' => ['placeholder' => 'Un numero'],
            ])            
            ->add('email', null, [
                'required' => true,
                'label'=> 'Correo electrónico',
                'attr' => ['placeholder' => 'correo@milenio.com'],
            ])
            ->add('phone', null, [
                'required' => true,
                'label'=> 'Telefono',
                'attr' => ['placeholder' => 'Numero telefónico de 10 digitos'],
            ])
            ->add('department', null, [
                'required' => true,
                'label'=> 'Departamento',
                'help' => 'Departamento al cual pertenece',
            ]);
        }

    public function preValidate($object): void
    {
        $name = trim((string) $this->getForm()->get('name')->getData());
        if ($name === '' || mb_strlen($name) > 70) {
            $this->getForm()->get('name')->addError(new FormError('Hubo un error con el campo nombre.'));
        }

        $employee_identifier = trim((string) $this->getForm()->get('employee_identifier')->getData());
        if ($employee_identifier === '' || mb_strlen($employee_identifier) > 10) {
            $this->getForm()->get('employee_identifier')->addError(new FormError('Hubo un error con el campo ID de empleado.'));
        }

        $employeeIdentifier = trim(
            (string) $this->getForm()->get('employee_identifier')->getData()
        );

        // $em = $this->getConfigurationPool();
        // dd($em);
        // $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();

        // $existingEmployee = null;
        // if ($employeeIdentifier !== '') {
        //     $existingEmployee = $em
        //         ->getRepository(Employee::class)
        //         ->createQueryBuilder('e')
        //         ->where('e.employee_identifier = :identifier')
        //         ->andWhere('e.id != :id')
        //         ->setParameter('identifier', $employeeIdentifier)
        //         ->setParameter('id', $object->getId() ?? 0)
        //         ->getQuery()
        //         ->getOneOrNullResult();
        // }

        // if ($employeeIdentifier === '' || mb_strlen($employeeIdentifier) > 10 || $existingEmployee !== null) {
        //     $this->getForm()->get('employee_identifier')->addError(new FormError('Hubo un error con el campo ID de empleado.'));
        // }
        if ($employeeIdentifier === '' || mb_strlen($employeeIdentifier) > 10) {
            $this->getForm()->get('employee_identifier')->addError(new FormError('Hubo un error con el campo ID de empleado.'));
        }

        $email = trim((string) $this->getForm()->get('email')->getData());
        if ($email === '' || mb_strlen($email) > 70 || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^\S+@milenio\.com$/', $email)) {
            $this->getForm()->get('email')->addError(new FormError('Hubo un error con el campo email.'));
        }

        $phone = trim((string) $this->getForm()->get('phone')->getData());
        if (!preg_match('/^\d{10}$/', $phone)) {
            $this->getForm()->get('phone')->addError(new FormError('Hubo un error con el campo teléfono.'));
        }

        $department = $this->getForm()->get('department')->getData();
        if ($department === null) {
            $this->getForm()->get('department')->addError(new FormError('Hubo un error con el campo departamento.'));
        }
    }
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('name', null, [
                'label' => 'Nombre del empleado',
            ])
            ->add('AttendanceRecordList', null, [
                'label' => 'Entradas y Salidas',
            ])
            ;
    }
}
