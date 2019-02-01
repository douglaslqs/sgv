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
	 * Total de páginas retornadas.
	 */
	private $totalPages;

	/**
	 * Intervalo das páginas
	 */
	private $range = '0-50';

	/**
	 * Intervalo ´máximo aceito
	 */
	private $acceptRange = 50;

	/**
	 * Página Atual
	 */
	private $currentPage;

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
		$this->range = $strRage;
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

	public function setCurrentPage($currentPage)
	{
		$this->currentPage = $currentPage;
	}

	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	public function setTotalPages($totalPages)
	{
		$this->totalPages = $totalPages;
	}

	public function getRageIni()
	{
		$arrExplode = (int)explode('-', $this->getRange());
		if (is_array($arrExplode)) {
			return $arrExplode[0];
		} else {
			return 0;
		}
	}

	public function getRageEnd()
	{
		$arrExplode = (int)explode('-', $this->getRange());
		if (is_array($arrExplode)) {
			return $arrExplode[1];
		} else {
			return $this->getAcceptRange();
		}
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}