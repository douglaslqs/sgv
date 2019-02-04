<?php
namespace Application\Service;

/**
 *
 * @author Douglas Santos <douglasrock15@hotmail.com>
 *
 */
class PaginatorService
{
	/**
	 * Total de dados retornados.
	 */
	private $totalData;

	/**
	 * Intervalo das páginas
	 */
	private $range = '0-50';

	/**
	 * Intervalo ´máximo aceito
	 */
	private $acceptRange = 50;

	/**
	 * Links de navegação
	 */
	private $links = array();

	public function __construct()
	{
		$this->links = array(
			'self'=> '',
			'first' => '',
			'prev' => '',
			'next' => '',
			'last' => '',
		);
	}

	public function setLinkSelf($strLinkSelf)
	{
		$this->links['self'] = $strLinkSelf;
	}

	public function getLinkSelf()
	{
		return $this->links['self'];
	}

	public function setLinkFirst($strLinkFirst)
	{
		$this->links['first'] = $strLinkFirst;
	}

	public function getLinkFirst()
	{
		return $this->links['first'];
	}

	public function setLinkPrev($strLinkPrev)
	{
		$this->links['prev'] = $strLinkPrev;
	}

	public function getLinkPrev()
	{
		return $this->links['prev'];
	}

	public function setLinkNext($strLinkNext)
	{
		$this->links['next'] = $strLinkNext;
	}

	public function getLinkNext()
	{
		return $this->links['next'];
	}

	public function setLinkLast($strLinkLast)
	{
		$this->links['last'] = $strLinkLast;
	}

	public function getLinkLast()
	{
		return $this->links['last'];
	}

	public function setRange($strRage)
	{
		$arrRage = explode('-', $strRage);
		if (!empty($arrRage)) {
			$range = (int)$arrRage[1] - (int)$arrRage[0];
			if ($range > $this->getAcceptRange()) {
				$arrRage[1] = (int)$arrRage[0]+$this->getAcceptRange();
				$this->range = $arrRage[0].'-'.$arrRage[1];
			} else {
				$this->range = $strRage;
			}
		}
		/**
		 * Set Link Self
		 */
		$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$rangeIni = $this->getRangeIni();
		$rangeEnd = $this->getRangeEnd();
		$linkSelf = str_replace('p_range='.$strRage, 'p_range='.$this->getRange(), $currentUrl);
		$this->setLinkSelf($linkSelf);
		/**
		 * Set Link First
		 */
		$linkSelf = str_replace('p_range='.$strRage, 'p_range=0-'.$this->getAcceptRange(), $currentUrl);
		$this->setLinkFirst($linkSelf);
		/**
		 * SET Link Prev
		 */
		$newRangeIni = $rangeIni - $this->getAcceptRange()-1;
		$newRangeIni = $newRangeIni > 0 ? $newRangeIni : 0;
		$newRangeEnd = $rangeEnd-1;
		$newRangeEnd = $newRangeEnd < 1 ? $this->getAcceptRange() : $newRangeEnd;
		$linkPrev = str_replace('p_range='.$strRage, 'p_range='.$newRangeIni.'-'.$newRangeEnd, $currentUrl);
		$this->setLinkPrev($linkPrev);
		/**
		 * Set Link Next
		 */
		$newRangeIni = $rangeIni + $this->getAcceptRange()+1;
		$newRangeIni = $newRangeIni > 0 ? $newRangeIni : 0;
		$newRangeEnd = $rangeEnd+$this->getAcceptRange()+1;
		$linkNext = str_replace('p_range='.$strRage, 'p_range='.$newRangeIni.'-'.$newRangeEnd, $currentUrl);
		$this->setLinkNext($linkNext);
	}

	public function getRange()
	{
		return $this->range;
	}

	public function setAcceptRange($intAcceptRange)
	{
		$this->acceptRange = $intAcceptRange;
	}

	public function getAcceptRange()
	{
		return $this->acceptRange;
	}

	public function setTotalData($totalData)
	{
		$this->totalData = $totalData;
	}

	public function getTotalData()
	{
		return $this->getTotalData;
	}

	public function getRangeIni()
	{
		$arrExplode = explode('-', $this->getRange());
		if (is_array($arrExplode) && !empty($arrExplode[0])) {
			return (int)$arrExplode[0];
		} else {
			return 0;
		}
	}

	public function getRangeEnd()
	{
		$arrExplode = explode('-', $this->getRange());
		if (is_array($arrExplode) && !empty($arrExplode[1])) {
			$rangeEnd = (int)$arrExplode[1];
			$interval = $rangeEnd-(int)$arrExplode[0];
			if ($interval <= $this->getAcceptRange() && $interval > 0) {
				return $rangeEnd;
			} else {
				return $this->getAcceptRange();
			}
		} else {
			return $this->getAcceptRange();
		}
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}