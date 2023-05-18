<?php

namespace App\Manager\Checker;

use App\Entity\Checker\CheckerLog;
use App\Manager\BaseManager\BaseExportManager;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CheckerLogExportManager extends BaseExportManager
{

    const FILENAME = 'url-check-link-log-export';

    /**
     * @param array $items
     *
     * @return Spreadsheet
     * @throws Exception
     */
    protected function getSpreadsheet(array $items): Spreadsheet
    {
        /**
         * @var $item CheckerLog
         */

        $spreadsheet = $this->spreadsheetFactory->createSpreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $columns = range('A', 'Z');

        $heading = [
            0 => 'ID',
            1 => $this->trans->trans('label.action'),
            2 => $this->trans->trans('label.response_value'),
            3 => $this->trans->trans('label.link_url'),
            4 => $this->trans->trans('label.date')
        ];

        foreach ($heading as $key => $title) {
            $sheet->setCellValue($columns[$key] . '1', $title);
            $sheet->getColumnDimension($columns[$key])->setAutoSize(true);
        }

        foreach ($items as $row => $item) {
            $data = [
                0 => $item->getID(),
                1 => $item->getAction(),
                2 => $item->getValue(),
                3 => $item->getLink()->getUrl(),
                4 => $item->getCreatedAt()->format('Y-m-d H:i'),
            ];

            foreach ($data as $key => $dataItem) {
                $pCoordinate = $columns[$key] . ($row + 2);
                $sheet->setCellValue($pCoordinate, $dataItem);
            }
        }

        return $spreadsheet;
    }
}