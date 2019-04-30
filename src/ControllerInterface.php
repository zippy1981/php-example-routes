<?php

namespace Router;

/**
 * All controllers must implement this interface.
 * @package Router
 */
interface ControllerInterface
{
    /**
     * Get action for the root of the controller.
     * @param $id1 int|string The parameter for the first level of the route.
     */
    public function index($id1): void;

    /**
     * GET action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function get($id1, $id2): void;

    /**
     * POST action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function create($id1): void;

    /**
     * PUT action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function update($id1, $id2): void;

    /**
     * DELETE action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function delete($id1, $id2): void;
}
