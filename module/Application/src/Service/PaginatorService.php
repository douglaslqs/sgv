<?php
namespace Application\Service;

/**
 *
 * @author Douglas Santos <douglasrock15@hotmail.com>
 *
 */
class PaginatorService
{

	private $totalPages;
	private $range;
	private $acceptRange = 50;
	private $currentPage;
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

	public function setRange($intRange)
	{
		$this->range = $intRange;
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

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}