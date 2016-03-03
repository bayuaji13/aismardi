<?php

class BatchInput extends CI_Controller {
	
	public function input_nilai($file)
	{	
		$inputFileType = PHPExcel_IOFactory::identify($file);

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		echo '<table>' . "\n";
		for ($row = 1; $row <= $highestRow; ++$row) {
			echo '<tr>' . "\n";
			for ($col = 0; $col <= $highestColumnIndex; ++$col) {
				echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . 
				'</td>' . "\n";
			}
			echo '</tr>' . "\n";
		}
		echo '</table>' . "\n";
	}
}