<?php
namespace App\Business\Order\Repositories;


use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Return collection using the given codes.
     *
     * @param array $ids
     * @return Collection
     */
    public function find(array $ids);

    /**
     * Get the type of the source being used.
     *
     * @return string
     */
    public function getSourceType();

    /**
     * return the collection
     *
     * @return Collection
     */
    public function get();

    /**
     * Render collection
     *
     * @param bool $console
     * @return string
     */
    public function render(bool $console = false);


}