<?php

namespace Ragnoria\Location\Position;

use Ragnoria\Location\Consts;
use Ragnoria\Location\Location;
use Ragnoria\Location\Contracts\HasPosition;

class Position
{
    /** @var array<string, array<int, HasPosition>> */
    protected array $container = [];

    /** @var array<string, array<int, <string, Position|HasPosition>>> */
    protected static array $index = [];


    /**
     * Get indicated object's position.
     *
     * @param HasPosition $object
     * @return Position|null
     */
    public static function for(HasPosition $object): ?Position
    {
        return static::$index[get_class($object)][spl_object_id($object)][Consts::INDEX_KEY_POSITION] ?? null;
    }


    /**
     * Position constructor.
     *
     * @param Location $location
     * @param int $x
     * @param int $y
     * @param int $z
     */
    public function __construct(
        protected Location $location,
        protected int $x,
        protected int $y,
        protected int $z
    )
    {
        //
    }

    /**
     * Get `X` axis point of current position.
     *
     * @return int
     */
    public function x(): int
    {
        return $this->x;
    }

    /**
     * Get `Y` axis point of current position.
     *
     * @return int
     */
    public function y(): int
    {
        return $this->y;
    }

    /**
     * Get `Z` axis point of current position.
     *
     * @return int
     */
    public function z(): int
    {
        return $this->z;
    }

    /**
     * Get `Location` instance of current position
     *
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * Get collection of assigned objects that are instances the indicated class.
     *
     * @param string $class
     * @return array|HasPosition[]
     */
    public function getStack(string $class): array
    {
        return $this->container[$class] ?? [];
    }

    /**
     * Assign given object to current position.
     * Indicated object will be automatically detached from its previous position.
     *
     * @param HasPosition $object
     */
    public function sync(HasPosition $object): void
    {
        if ($position = static::for($object)) {
            $position->detach($object);
        }
        $this->container[get_class($object)][spl_object_id($object)] = $object;
        static::$index[get_class($object)][spl_object_id($object)] = [
            Consts::INDEX_KEY_POSITION => $this,
            Consts::INDEX_KEY_OBJECT => $object
        ];
    }

    /**
     * Unset given object's position.
     *
     * @param HasPosition $object
     */
    public function detach(HasPosition $object): void
    {
        unset(static::$index[get_class($object)][spl_object_id($object)]);
        unset($this->container[get_class($object)][spl_object_id($object)]);
        if (empty($this->container[get_class($object)])) {
            unset($this->container[get_class($object)]);
        }
    }

}
