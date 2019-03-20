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
	private $range = '0-10';

	/**
	 * Intervalo
	 */
	private $interval = 20;

	/**
	 * Intervalo máximo aceito
	 */
	private $acceptedInterval = 50;


	/**
	 * Links de navegação
	 */
	private $links = array();

	public function __construct()
	{
		$this->links = array(
			'self'=> '#1',
			'first' => '#1',
			'prev' => '#1',
			'next' => '#1',
			'last' => '#1',
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
			$interval = (int)$arrRage[1] - (int)$arrRage[0];
			if ($interval > $this->getAcceptedInterval()) {
				$arrRage[1] = (int)$arrRage[0]+$this->getAcceptedInterval();
				$this->range = $arrRage[0].'-'.$arrRage[1];
				$interval = (int)$arrRage[1] - (int)$arrRage[0];
			} else {
				$this->range = $strRage;
			}
			if ($interval > 0) {
				$this->setInterval($interval);
			}
		}
		$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if (strpos($currentUrl, 'p_range') === false) {
			$currentUrl = $currentUrl.'?p_range='.$this->getRange();
		}

		$rangeIni = $this->getRangeIni();
		$rangeEnd = $this->getRangeEnd();
		/**
		 * Set Link Self
		 */
		$linkSelf = str_replace('p_range='.$strRage, 'p_range='.$this->getRange(), $currentUrl);
		$this->setLinkSelf($linkSelf);
		/**
		 * Set Link First
		 */
		$linkSelf = str_replace('p_range='.$strRage, 'p_range=0-'.$this->getInterval(), $currentUrl);
		$this->setLinkFirst($linkSelf);
		/**
		 * SET Link Prev
		 */
		$newRangeIni = $rangeIni - $this->getInterval()-1;
		$newRangeIni = $newRangeIni > 0 ? $newRangeIni : 0;
		$newRangeEnd = $rangeIni-1;
		$newRangeEnd = $newRangeEnd < 1 ? $this->getInterval() : $newRangeEnd;
		$newRangeEnd = $newRangeEnd < $this->getInterval() ? $this->getInterval() : $newRangeEnd;
		$linkPrev = str_replace('p_range='.$strRage, 'p_range='.$newRangeIni.'-'.$newRangeEnd, $currentUrl);
		$this->setLinkPrev($linkPrev);
		/**
		 * Set Link Next
		 */
		$newRangeIni = $rangeIni + $this->getInterval();
		$newRangeIni = $newRangeIni > 0 ? $newRangeIni : 0;
		$newRangeEnd = $rangeEnd+$this->getInterval();
		$linkNext = str_replace('p_range='.$strRage, 'p_range='.$newRangeIni.'-'.$newRangeEnd, $currentUrl);
		$this->setLinkNext($linkNext);
	}

	public function getRange()
	{
		return $this->range;
	}

	public function setInterval($interval)
	{
		$this->interval = $interval;
	}

	public function getInterval()
	{
		return $this->interval;
	}

	public function setAcceptedInterval($intacceptedInterval)
	{
		$this->acceptedInterval = $intacceptedInterval;
	}

	public function getAcceptedInterval()
	{
		return $this->acceptedInterval;
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
			if ($interval <= $this->getAcceptedInterval() && $interval > 0) {
				return $rangeEnd;
			} else {
				return $this->getAcceptedInterval();
			}
		} else {
			return $this->getAcceptedInterval();
		}
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}