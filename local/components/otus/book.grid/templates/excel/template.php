<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

while (ob_get_level()) {
    ob_end_clean();
}

$spreadSheet = new Spreadsheet();
$activeSheet = $spreadSheet->getActiveSheet();

$headersStyleArray = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '000000'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
];

$rowStyleArray = [
    'font' => [
        'italic' => true,
        'color' => ['rgb' => '0000ff'],
    ],
];

// --- Заголовки ---
$colIndex = 1; // 1..N
foreach ($arResult['USED_HEADERS'] as $header) {
    // A1 B1 C1 D1 E1 F1 ... AAA1 AAB1
    $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
    $activeSheet->setCellValue($cell, $header);
    $colIndex++;
}

$lastHeaderCol = $colIndex - 1;

// применяем стиль на строку заголовков
if ($lastHeaderCol >= 1) {
    $start = 'A1';
    $end = Coordinate::stringFromColumnIndex($lastHeaderCol) . '1';
    // Примени для ячеек A1 ... F1 стили
    $activeSheet->getStyle($start . ':' . $end)->applyFromArray($headersStyleArray);
}

// $arResult['USED_HEADERS'] = array_column($arResult['USED_HEADERS'], 'id');
// --- Данные ---
$row = 2;
foreach ($arResult['GRID_LIST'] as $item) {
    $colIndex = 1;

    foreach ($item['data'] as $fieldId => $itemText) {
        if (in_array($fieldId, $arResult['USED_HEADERS'], true)) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . $row;
            $activeSheet->setCellValue($cell, $itemText);
            $colIndex++;
        }
    }

    $lastDataCol = $colIndex - 1;

    if ($row % 2 === 0 && $lastDataCol >= 1) {
        $start = 'A' . $row;
        $end = Coordinate::stringFromColumnIndex($lastDataCol) . $row;
        $activeSheet->getStyle($start . ':' . $end)->applyFromArray($rowStyleArray);
    }

    $row++;
}

// --- AutoSize только для реально используемых колонок ---
$maxCol = max(1, $lastHeaderCol);
for ($i = 1; $i <= $maxCol; $i++) {
    $colLetter = Coordinate::stringFromColumnIndex($i);
    $activeSheet->getColumnDimension($colLetter)->setAutoSize(true);
}

$activeSheet->setTitle('Книги');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="books.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadSheet);
$writer->save('php://output');

die();
