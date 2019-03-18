<?php

namespace App\Controller\API;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use App\Service\API\EmployeeService;
use App\Entity\Employee;
use App\Form\EmployeeType;

use App\Service\API\EmployeePhoneService;
use App\Entity\EmployeePhone;
use App\Form\EmployeePhoneType;

/**
 * Movie controller.
 * @Route("/api/v1", name="api_")
 */
class EmployeesController extends FOSRestController
{
    protected $employeeService;

    protected $employeePhoneService;

    public function __construct(EmployeeService $employeeService, EmployeePhoneService $employeePhoneService)
    {
        $this->employeeService      = $employeeService;
        $this->employeePhoneService = $employeePhoneService;
    }

    /**
     * Create Employee.
     * @Rest\Post("/employees")
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $em   = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $employee     = new Employee();
        $employeeForm = $this->createForm(EmployeeType::class, $employee);

        $employeeForm->submit($data);

        foreach ($data['phoneNumbers'] as $phone) {
            $employeePhone     = new EmployeePhone();
            $employeePhoneForm = $this->createForm(EmployeePhoneType::class, $employeePhone);

            $employeePhoneForm->submit($phone);

            if ($employeePhoneForm->isSubmitted() && $employeePhoneForm->isValid()) {
                $employee->addEmployeePhone($employeePhone);
            }
        }

        if (! $employeeForm->isSubmitted() || ! $employeeForm->isValid()) {
            return $this->handleView($this->view($employeeForm->getErrors()));
        }

        $em->persist($employee);
        $em->persist($employeePhone);
        $em->flush();

        return $this->handleView($this->view([
            'status' => 'ok'
        ], Response::HTTP_CREATED));

        // $employeePhone     = new EmployeePhone();
        // $employeePhoneForm = $this->createForm(EmployeePhoneType::class, $employeePhone);

        // $result = $this->employeePhoneService->create($em, $employeePhoneForm, $data);

        // if ($result) {
        //     return $this->handleView($this->view([
        //         'status' => 'ok'
        //     ], Response::HTTP_CREATED));
        // }


    }
}
