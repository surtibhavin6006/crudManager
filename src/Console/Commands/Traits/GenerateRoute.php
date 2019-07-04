<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 2:18 PM
 */

namespace Maven\CrudManager\Console\Commands\Traits;
use Illuminate\Support\Facades\File;

trait GenerateRoute
{
    protected function route()
    {
        $routeContinent = "\nRoute::apiResource('{$this->getPluralLowerCase($this->name)}', 'Api\\{$this->getUCFirst($this->name)}Controller');";

        $routePath = base_path('routes/api.php');

        File::append($routePath, $routeContinent);
    }
}