<?php

namespace App\Controller;

use App\Form\ColumnSelectorType;
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
        $columnSelectorForm = $this->createForm(ColumnSelectorType::class, options: [
            'method' => 'GET'
        ]);

        $columnSelectorForm->handleRequest($request);
        $displayedColumns = [0, 1, 2, 3];
        if ($columnSelectorForm->isSubmitted() && $columnSelectorForm->isValid()) {
            $displayedColumns = array_keys(array_filter($columnSelectorForm->getData(), function ($column) {
                return $column;
            }));
        }

        $tableData = array_map(function (array $data) use ($displayedColumns) {
            return array_intersect_key($data, $displayedColumns);
        }, $this->arrayData());

        return $this->render('table/table.html.twig', [
            'page' => $request->get('page'),
            'tableData' => $tableData,
            'columnSelector' => $columnSelectorForm->createView()
        ]);
    }

    private function arrayData(): array
    {
        return [
            ['header0', 'header1', 'header2', 'header3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3'],
            ['value0', 'value1', 'value2', 'value3']
        ];
    }
}
