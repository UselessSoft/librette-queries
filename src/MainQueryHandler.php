<?php

declare(strict_types=1);

namespace Librette\Queries;

use Kdyby\StrictObjects\Scream;

/**
 * @author David Matejka
 */
class MainQueryHandler implements IQueryHandler
{
    use Scream;

	/** @var IQueryHandler[] */
	private $handlers = [];

	/** @var IQueryModifier[] */
	private $modifiers = [];


	/**
	 * @param IQueryHandler
	 */
	public function addHandler(IQueryHandler $handler) : void
	{
		$this->handlers[] = $handler;
	}


	/**
	 * @param IQueryModifier
	 */
	public function addModifier(IQueryModifier $queryModifier) : void
	{
		$this->modifiers[] = $queryModifier;
	}


	public function supports(IQuery $query) : bool
	{
		foreach ($this->handlers as $handler) {
			if ($handler->supports($query)) {
				return TRUE;
			}
		}

		return FALSE;
	}


	/**
	 * @param IQuery
	 * @return mixed|IResultSet
	 */
	public function fetch(IQuery $query)
	{
		$handler = $this->resolveHandler($query);
		if ($handler === NULL) {
			throw new InvalidArgumentException("Unsupported query.");
		}

		foreach ($this->modifiers as $modifier) {
			$modifier->modify($query);
		}

		return $handler->fetch($query);
	}


	private function resolveHandler(IQuery $query) : ?IQueryHandler
	{
		foreach ($this->handlers as $handler) {
			if ($handler->supports($query)) {
				return $handler;
			}
		}

		return NULL;
	}
}
