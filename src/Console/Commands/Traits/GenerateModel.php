<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 12:47 PM
 */

namespace Maven\CrudManager\Console\Commands\Traits;
use Illuminate\Support\Facades\File;

trait GenerateModel
{
    protected function model()
    {
        $modelTemplate = str_replace(
            ['{{modelUcFirstName}}'],
            [$this->getUCFirst($this->name)],
            $this->getStub('Model')
        );

        $modelBasePath = app_path("/Models");

        if(!File::isDirectory($modelBasePath)){
            File::makeDirectory($modelBasePath, 0777, true);
        }

        $modelDirPath = $modelBasePath."/".$this->getUCFirst($this->name);

        if(!File::isDirectory($modelDirPath)){
            File::makeDirectory($modelDirPath, 0777, true);
        }

        $modelPath = "{$modelDirPath}/{$this->getUCFirst($this->name)}.php";

        File::put($modelPath, $modelTemplate);
    }
}