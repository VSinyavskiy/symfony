<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use App\Entity\Employee;
use App\Form\EmployeeType;

use App\Entity\EmployeePhone;
use App\Form\EmployeePhoneType;

/**
 * Employee controller.
 * @Route("/api/v1", name="api_")
 */
class EmployeesController extends FOSRestController
{
    /**
     * Create Employee.
     * @Rest\Post("/employees")
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $em   = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $employee     = new Employee();
        $employeeForm = $this->createForm(EmployeeType::class, $employee);

        $employeeForm->submit($data);

        if (! $employeeForm->isSubmitted() || ! $employeeForm->isValid()) {
            return $this->handleView($this->view($employeeForm->getErrors()));
        }

        $em->persist($employee);

        foreach ($data['phoneNumbers'] ?? [] as $phone) {
            $employeePhone     = new EmployeePhone();
            $employeePhoneForm = $this->createForm(EmployeePhoneType::class, $employeePhone);

            $employeePhoneForm->submit([
                'phone' => $phone
            ]);

            if ($employeePhoneForm->isSubmitted() && $employeePhoneForm->isValid()) {
                $employee->addEmployeePhone($employeePhone);

                $em->persist($employeePhone);
            }
        }

        $em->flush();

        return $this->handleView($this->view([
            'status' => 'saved'
        ], Response::HTTP_CREATED));
    }
}
