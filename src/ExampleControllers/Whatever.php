<?php

namespace Router\ExampleControllers;

use Router\ControllerInterface;

class Whatever implements ControllerInterface
{
    /**
     * Get action for the root of the controller.
     * @param $wid int|string The parameter for the first level of the route.
     */
    public function index($wid): void
    {
        header('Content-type: text/plain');
        echo "All of the whatevers\n";
    }

    /**
     * GET action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function get($id1, $id2): void
    {
        header('Content-type: text/plain');
        echo "Whatever #$id1\n";
    }

    /**
     * POST action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     * @throws \Exception
     */
    public function create($id1): void
    {
        header('Content-type: text/plain');
        $wid = random_int(0, 100);
        echo "You've made whatever #$wid\n";
    }

    /**
     * PUT action for the controller with parameters.
     * @param $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function update($id1, $id2): void
    {
        header('Content-type: text/plain');
        echo "Successfully updated #$id1\n";
    }

    /**
     * DELETE action for the controller with parameters.
     * @param  $id1 int|string The parameter for the first level of the route
     * @param $id2 int|string The parameter for the second level of the route
     */
    public function delete($id1, $id2): void
    {
        header('Content-type: text/plain');
        echo "Successfully deleted #$id1\n";
    }
}
