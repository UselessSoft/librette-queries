<?php

declare(strict_types=1);

namespace LibretteTests\Queries\Mocks;

use Kdyby\StrictObjects\Scream;
use Librette\Queries\IResultSet;

/**
 * @author David Matejka
 */
class ResultSet implements \IteratorAggregate, IResultSet
{
    use Scream;

	/** @var array */
	private $data;

	/** @var array */
	private $paginated;


	public function __construct(array $data)
	{
		$this->data = $this->paginated = $data;
	}


	public function applyPaging(int $offset, int $limit) : IResultSet
	{
		$this->paginated = array_slice($this->data, $offset, $limit);
		return $this;
	}


	public function getTotalCount() : int
	{
		return count($this->data);
	}


	public function count() : int
	{
		return count($this->paginated);
	}


	public function getIterator() : iterable
	{
		return new \ArrayIterator($this->data);
	}

}
