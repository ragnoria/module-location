<?php

namespace Ragnoria\Location;

use Ragnoria\Location\Position\Position;
use Ragnoria\Location\Position\PositionsCollection;

class Location
{
    protected PositionsCollection $positionsCollection;


    /**
     * Location constructor.
     *
     * @param string $name
     */
    public function __construct(protected string $name)
    {
        $this->positionsCollection = new PositionsCollection($this);
    }

    /**
     * Get name of location.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get collection of current location positions.
     *
     * @return PositionsCollection
     */
    public function getPositions(): PositionsCollection
    {
        return $this->positionsCollection;
    }

    /**
     * Get exact position from current location positions collection.
     *
     * @param int $x
     * @param int $y
     * @param int $z
     * @return Position|null
     */
    public function getPosition(int $x = 1, int $y = 1, int $z = 1): ?Position
    {
        return $this->positionsCollection->get($x, $y, $z);
    }

}
