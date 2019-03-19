<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\RequestPresenter\EmployeeWebRequestPresenter;
use App\Presenter\Employee\WebPresenter;
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
        $requestPresenter = new EmployeeWebRequestPresenter(
                                    $request->query->get('search'),
                                    $request->query->get('order')
                            );
        $findedEmployees  = $this->employeeRepository->findByFirstNameAndLastNameFields($requestPresenter);

        $employees = [];
        foreach ($findedEmployees as $item) {
            $employees[] = new WebPresenter($item);
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'items' => $this->render('employees/_items.html.twig', compact('employees'))->getContent(),
            ]);
        }

        return $this->render('employees/index.html.twig', compact('employees'));
    }
}
