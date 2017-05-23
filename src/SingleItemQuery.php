<?php

declare(strict_types=1);

namespace Librette\Queries;

use Kdyby\StrictObjects\Scream;

class SingleItemQuery implements QueryInterface, OuterQueryInterface
{
    use Scream;

	/** @var QueryInterface */
	private $query;


	public function __construct(QueryInterface $query)
	{
		$this->query = $query;
	}


	/**
	 * @return QueryInterface
	 */
	public function getInnerQuery() : QueryInterface
	{
		return $this->query;
	}

}
