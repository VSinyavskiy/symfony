<?php

namespace App\Service\API;

class EmployeeService
{
    public function create($entityManager, $employeeForm, $data)
    {
        $employeeForm = $this->createForm(EmployeeType::class, $this->employee);

        $employeeForm->submit($data);

        // foreach ($data['phoneNumbers'] as $number) {
        //     $employeePhoneForm = $this->createForm(EmployeePhoneType::class, $this->employeePhone);

        //     $employeePhoneForm->submit($number);

        //     if ($employeePhoneForm->isSubmitted() && $employeePhoneForm->isValid()) {
        //         $em->persist($employeePhoneForm);

        //         $employeeForm->addEmployeePhone($employeePhoneForm);
        //     }
        // }

        if ($employeeForm->isSubmitted() && $employeeForm->isValid()) {
            $entityManager->persist($employeeForm);
            $entityManager->flush();
        } else {
            $employeeErrors = $employeeForm->getErrors();
        }

        return ($employeeErrors + $employeeErrors) ?? true;
    }
}
