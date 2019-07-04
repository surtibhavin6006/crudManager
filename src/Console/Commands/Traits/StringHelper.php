<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 11:30 AM
 */

namespace Maven\CrudManager\Console\Commands\Traits;


use Illuminate\Support\Str;

trait StringHelper
{
    public function getCamelCase($name)
    {
        return Str::camel($name);
    }

    public function getCamelCaseSingle($name)
    {
        return Str::camel(Str::singular($name));
    }

    public function getCamelCasePlural($name)
    {
        return Str::camel(Str::plural($name));
    }

    public function getUCFirstSingle($name)
    {
        return ucfirst(Str::singular($name));
    }

    public function getUCFirstPlural($name)
    {
        return ucfirst(Str::plural($name));
    }

    public function getUCFirst($name)
    {
        return ucfirst($name);
    }

    public function getSingular($name)
    {
        return Str::singular($name);
    }

    public function getPlural($name)
    {
        return Str::plural($name);
    }

    public function getPluralLowerCase($name)
    {
        return strtolower(Str::plural($name));
    }

    public function getSingularLowerCase($name)
    {
        return strtolower(Str::singular($name));
    }

    public function getLowerCase($name)
    {
        return strtolower($name);
    }


}