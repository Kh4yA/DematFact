<?php

namespace App\Controller;

use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\FactureRepository;
use Doctrine\DBAL\Query\Limit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DashbordController extends AbstractController
{
    #[Route('/dashbord', name: 'app_dashbord')]
    public function index(ChartBuilderInterface $chartBuilder, FactureRepository $factures): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $documents = $factures->findby(
            array(),
            array('id' => 'DESC'),
            5,
            0
        );
        $route = ($_SERVER['REQUEST_URI']);
        $chart->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            'datasets' => [
                [
                    'label' => '2024',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 1000, 1255, 2354, 2045, 3650, 1545],
                ],
                [
                    'label' => '2025',
                    'backgroundColor' => 'rgb(40, 230, 71)',
                    'borderColor' => 'rgb(40, 230, 71)',
                    'data' => [1498, 2577, 6458, 1254, 6, 3524, 2443],
                ],
            ],
        ]);
    
        $chart->setOptions([
            'responsive' => true,  // Rend le graphique adaptatif
            'maintainAspectRatio' => false, // Permet au graphique de s'agrandir sans contrainte
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10000,
                    'title' => [
                        'display' => true,
                        'text' => 'Valeurs en €uros',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
            ],
        ]);
    
        return $this->render('dashbord/index.html.twig', [
            'chart' => $chart,
            'documents' => $documents,
            'route' => $route,
        ]);
    }}
