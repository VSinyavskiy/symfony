<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesController extends AbstractController
{
    /**
     * @Route("/a/p/i/employees", name="a_p_i_employees")
     */
    public function index()
    {
        return $this->render('api/employees/index.html.twig', [
            'controller_name' => 'EmployeesController',
        ]);
    }
}
