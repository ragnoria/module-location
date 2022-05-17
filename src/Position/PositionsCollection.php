<?php

namespace Ragnoria\Location\Position;

use Ragnoria\Location\Consts;
use Ragnoria\Location\Exceptions\LocationException;
use Ragnoria\Location\Location;

class PositionsCollection
{
    /** @var array<int, array<int, <int, Position>>> */
    protected array $container;


    /**
     * PositionsCollection constructor.
     *
     * @param Location $location
     */
    public function __construct(protected Location $location)
    {
        //
    }

    /**
     * Add new position to collection.
     *
     * @param int $x
     * @param int $y
     * @param int $z
     * @return Position
     * @throws LocationException
     */
    public function add(int $x = 1, int $y = 1, int $z = 1): Position
    {
        if (isset($this->container[$z][$y][$x])) {
            throw new LocationException(Consts::EXCEPTION_DUPLICATED_POSITION);
        }

        return $this->container[$z][$y][$x] = new Position($this->location, $x, $y, $z);
    }

    /**
     * Get position from collection for indicated coords.
     *
     * @param int $x
     * @param int $y
     * @param int $z
     * @return Position|null
     */
    public function get(int $x = 1, int $y = 1, int $z = 1): ?Position
    {
        return $this->container[$z][$y][$x] ?? null;
    }

    /**
     * Alias for get() method with fallback to add() method.
     *
     * @param int $x
     * @param int $y
     * @param int $z
     * @return Position
     * @throws LocationException
     */
    public function getOrAdd(int $x = 1, int $y = 1, int $z = 1): Position
    {
        return $this->get($x, $y, $z) ?? $this->add($x, $y, $z);
    }

}
