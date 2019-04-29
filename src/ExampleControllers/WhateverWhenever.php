<?php

namespace Router\ExampleControllers;

use Router\ControllerInterface;

class WhateverWhenever implements ControllerInterface
{
    /**
     * Get action for the root of the controller.
     * @param $id int|string The parameter for the first level of the route.
     */
    public function index($id): void
    {
        // TODO: Implement index() method.
    }

    /**
     * GET action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function get($id1, $id2): void
    {
        // TODO: Implement get() method.
    }

    /**
     * POST action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function create($id1): void
    {
        // TODO: Implement create() method.
    }

    /**
     * PUT action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function update($id1, $id2): void
    {
        // TODO: Implement update() method.
    }

    /**
     * DELETE action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function delete($id1, $id2): void
    {
        // TODO: Implement delete() method.
    }
}
