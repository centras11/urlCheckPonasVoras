<?php

namespace App\Manager\Link;

use App\Entity\Link;
use App\Manager\BaseManager\BaseExportManager;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LinkExportManager extends BaseExportManager
{

    const FILENAME = 'url-check-link-export';

    /**
     * @param array $items
     *
     * @return Spreadsheet
     * @throws Exception
     */
    protected function getSpreadsheet(array $items): Spreadsheet
    {
        /**
         * @var $item Link
         */

        $spreadsheet = $this->spreadsheetFactory->createSpreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $columns = range('A', 'Z');

        $heading = [
            0 => 'ID',
            1 => $this->trans->trans('label.link_title'),
            2 => $this->trans->trans('label.link_url'),
            3 => $this->trans->trans('label.date')
        ];

        foreach ($heading as $key => $title) {
            $sheet->setCellValue($columns[$key] . '1', $title);
            $sheet->getColumnDimension($columns[$key])->setAutoSize(true);
        }

        foreach ($items as $row => $item) {
            $data = [
                0 => $item->getID(),
                1 => $item->getUrl(),
                2 => $item->getTitle(),
                3 => $item->getCreatedAt()->format('Y-m-d H:i'),
            ];

            foreach ($data as $key => $dataItem) {
                $pCoordinate = $columns[$key] . ($row + 2);
                $sheet->setCellValue($pCoordinate, $dataItem);
            }
        }

        return $spreadsheet;
    }
}