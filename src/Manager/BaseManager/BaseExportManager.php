<?php

namespace App\Manager\BaseManager;

use App\Interface\BaseExportManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Yectep\PhpSpreadsheetBundle\Factory as SpreadsheetFactory;

class BaseExportManager implements BaseExportManagerInterface
{

    const FILENAME = '-';

    public function __construct(
        protected SpreadsheetFactory $spreadsheetFactory,
        protected TranslatorInterface $trans
    ) {
    }

    /**
     * @param $items
     *
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception|Exception
     */
    public function exportXls($items): Response
    {
        $spreadsheet = $this->getSpreadsheet($items);
        $writer = $this->spreadsheetFactory->createWriter($spreadsheet, 'Xlsx');

        ob_start();

        $writer->save('php://output');

        return new Response(
            ob_get_clean(), 200,
            [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="' . static::FILENAME . '_' . time() . '.xlsx"',
            ]
        );
    }

    /**
     * @param array $items
     *
     * @return Spreadsheet
     * @throws Exception
     */
    protected function getSpreadsheet(array $items): Spreadsheet
    {
        return $this->spreadsheetFactory->createSpreadsheet();
    }
}