<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/table', name: 'table.')]
class TableController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $frameId = $request->headers->get('Turbo-Frame');
        if ($frameId && method_exists($this, $frameId)) {
            return $this->$frameId($request);
        }

        return $this->render('table/index.html.twig');
    }

    public function expensiveTable(Request $request): Response
    {
        sleep(1);
        return $this->render('table/table.html.twig', [
            'page' => $request->get('page')
        ]);
    }
}
