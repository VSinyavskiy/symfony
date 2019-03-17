<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\RequestPresenter\EmployeeRequestPresenter;
use App\Repository\EmployeeRepository;

class EmployeesController extends AbstractController
{
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @Route("/employees", name="employees", methods={"GET"})
     */
    public function index(Request $request)
    {
        $request   = new EmployeeRequestPresenter($request);
        $employees = $this->employeeRepository->findByFirstNameAndLastNameFields($request);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'items' => $this->render('employees/_items.html.twig', compact('employees'))->getContent(),
            ]);
        }

        return $this->render('employees/index.html.twig', compact('employees'));
    }
}
