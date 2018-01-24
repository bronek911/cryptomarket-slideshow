<?php
/*
 * LabCharts version 1.2
 * http://www.code-laboratory.com/
 *
 * Copyright (c) 2009 http://code-laboratory.com
 * Dual licensed under the MIT and GPL licenses.
 *
 * 2009-12-04 19:00
 * 2010-01-30 13:25 edited to v 1.1
 * 2010-05-22 22:47 edited to v 1.2
 */

namespace App\Entity;
use App\Entity\LabCharts;

class LabChartsLine extends LabCharts {
    
    private $min;
    private $max;
    
    public function __construct () {
        $this->_type = 'lc';
        $this->_colors = 'FAAC02';
        $this->_size = '300x150';
    }
    protected function dataToString ($data) {
        $str = 't:';
        $this->max = max($data);
        $this->min = min($data);

        foreach ($data as $value) {
			$newValue = round((1 - ($this->max - $value) / ($this->max - $this->min)) * 100, 3);
            $str .= $newValue . ',';
        }
        return substr($str, 0, -1);
    }

    public function setAxis ($rangeY, $labelsX) {
		
		$newRange = round($rangeY / ($this->max - $this->min) * 100, 3);

		$strLabels = '0:';
		$strPosition = '0';
		for ($a = $this->getFirstOfRange($rangeY); $a <= $this->max; $a += $rangeY) {
			$strLabels .= '|' . $a;
		}
		for ($a = $this->getFirstGrid($rangeY); $a <= 100; $a += $newRange) {
			$strPosition .= ',' . $a;
		}
		$this->_axis = 'y,x';
		$this->_axisRange = $strLabels . '|1:|' . $labelsX;
		$this->_axisPosition = $strPosition;
	}
	
	public function setGrids ($rangeY) {
		$newRangeY = round($rangeY / ($this->max - $this->min) * 100, 3);
		$newRangeX = round(100 / (count($this->baseData) - 1), 2);
		$this->_grids = $newRangeX . ',' . $newRangeY . ',3,3,0,' . $this->getFirstGrid($rangeY);
	}
    
    private function getFirstGrid($rangeY) {
		return round((1 - ($this->max - $this->getFirstOfRange($rangeY)) / ($this->max - $this->min)) * 100, 3);
	}
	
	private function getFirstOfRange($rangeY){
		for ($pierwszyPodzielny = $this->min; $pierwszyPodzielny <= $this->max; $pierwszyPodzielny++){
			if (abs($pierwszyPodzielny) % $rangeY == 0 || $pierwszyPodzielny == 0)
				break;
		}
		return $pierwszyPodzielny;
	}
    
}

?>
