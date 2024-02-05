<?php

use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class CustomBinder extends DefaultValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        // Custom logic to bind the value
        $stringValue = // Convert $value to a string or handle it accordingly
        parent::bindValue($cell, $stringValue);
    }
}

// Use the custom binder
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setAutoSize(true);
$spreadsheet->getActiveSheet()->getCell('A1')->setValue('Your value');
$spreadsheet->getActiveSheet()->getCell('A1')->getStyle()->getNumberFormat()->setFormatCode('0');
$spreadsheet->getActiveSheet()->getCell('A1')->setValueExplicit('0', DataType::TYPE_STRING);
$spreadsheet->getActiveSheet()->getCell('A1')->setValueExplicit('0', DataType::TYPE_STRING);

