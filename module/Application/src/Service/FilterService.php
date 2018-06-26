<?php
namespace Application\Service;

/**
 * Filter Data. Default all the filters is true. Call method of filter name to desable
 * @author Douglas Santos <douglasrock15@hotmail.com>
 *
 */
class FilterService
{

	private $trim = true;
	private $tag = true;
	private $doubleSpace = true;
	private $arrData = array();
	private $arrSet = array();
	private $arrWhere = array();

	public function trim($boolval)
	{
		$this->trim = $boolval;
		return $this;
	}

	public function tag($boolval)
	{
		$this->tag = $boolval;
		return $this;
	}

	public function doubleSpace($boolval)
	{
		$this->doubleSpace = $boolval;
		return $this;
	}

	public function setData(array $arrData)
	{
		$this->arrData = $arrData;
		return $this;
	}

	/**
	 * Apply filters and return data
	 * @return array data seted
	 */
	public function getData()
	{
		$arrNewData = $this->arrData;
		foreach ($arrNewData as $key => $value) {
			if ($this->trim) {
				$value = trim($value);
				$arrNewData[$key] = $value;
			}
			if ($this->tag) {
				$value = strip_tags($value);
				$arrNewData[$key] = $value;
			}
			if ($this->doubleSpace) {
				$value = preg_replace('/( )+/', ' ', $value);
				$arrNewData[$key] = $value;
			}
		}
		$this->arrData = $arrNewData;
		return $arrNewData;
	}

	public function getArraySet()
	{
		if (empty($this->arrSet)) {
			$this->setArrSetAndWhere();
		}
        return $this->arrSet;
	}

	public function getArrayWhere()
	{
		if (empty($this->arrWhere)) {
			$this->setArrSetAndWhere();
		}
		return $this->arrWhere;
	}

	/**
	 * Set array "set" and "where" from update utilized prefix "new_"
	 */
	private function setArrSetAndWhere()
	{
		$arrSet = array();
		$this->arrWhere = $this->arrData;
        foreach ($this->arrWhere as $key => $value) {
            if (strpos($key, 'new_') !== false) {
                $newKey = str_replace('new_', '', $key);
                $arrSet[$newKey] = $this->arrWhere[$key];
                unset($this->arrWhere[$key]);
            }
            if (strpos($key, 'p_') !== false) {
                unset($this->arrWhere[$key]);
            }
        }
        $this->arrSet = $arrSet;
	}
}