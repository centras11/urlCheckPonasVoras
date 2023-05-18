<?php

declare(strict_types=1);

namespace App\Interface;

use Symfony\Component\HttpFoundation\Response;

interface BaseExportManagerInterface
{
    public function exportXls($items): Response;
}