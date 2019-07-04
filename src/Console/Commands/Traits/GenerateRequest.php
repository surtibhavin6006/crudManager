<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 1:13 PM
 */

namespace Maven\CrudManager\Console\Commands\Traits;
use Illuminate\Support\Facades\File;

trait GenerateRequest
{
    protected function request()
    {
        $createRequestTemplate = str_replace(
            [
                '{{modelUcFirstName}}',
                '{{Method}}'
            ],
            [
                $this->getUCFirst($this->name),
                'Create'
            ],
            $this->getStub('Request')
        );

        $updateRequestTemplate = str_replace(
            [
                '{{modelUcFirstName}}',
                '{{Method}}'
            ],
            [
                $this->getUCFirst($this->name),
                'Update'
            ],
            $this->getStub('Request')
        );


        $RequestApiDirPath = app_path("/Http/Requests/Api");

        if(!File::isDirectory($RequestApiDirPath)){
            File::makeDirectory($RequestApiDirPath, 0777, true);
        }

        $RequestApiDirPathModel = "{$RequestApiDirPath}/{$this->getUCFirst($this->name)}";
        if(!File::isDirectory($RequestApiDirPathModel)){
            File::makeDirectory($RequestApiDirPathModel, 0777, true);
        }

        $createRequestPath = "{$RequestApiDirPathModel}/CreateRequest.php";
        $updateRequestPath = "{$RequestApiDirPathModel}/UpdateRequest.php";

        File::put($createRequestPath, $createRequestTemplate);
        File::put($updateRequestPath, $updateRequestTemplate);
    }
}