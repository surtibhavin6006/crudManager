<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 12:54 PM
 */

namespace Maven\CrudManager\Console\Commands\Traits;
use Illuminate\Support\Facades\File;

trait GenerateResource
{
    protected function generateResource()
    {
        $resourceArray = "[\n\t\t\t'type'\t=>\t'".strtolower($this->name)."',";
        $resourceArray .= "\n\t\t\t'id'\t=>\t(string)".'$this->id,'."\n\t\t\t";
        $resourceArray .= "'attributes'\t=>\t[\n\t\t\t\t";

        foreach($this->fieldsTypesAndValidations as $fieldTypeAndValidation){
            $resourceArray .= "'".$fieldTypeAndValidation['fieldName']."'=>\t";
            $resourceArray .= '$this->'.$fieldTypeAndValidation['fieldName'].",\n\t\t\t\t";
        }

        $resourceArray .= "\n\t\t\t],\n\t\t];";

        $resourceTemplate = str_replace(
            [
                '{{modelUcFirstName}}',
                '{{modelSingleUcFirstName}}',
                '{{FieldsArray}}'
            ],
            [
                $this->getUCFirst($this->name),
                $this->getUCFirstSingle($this->name),
                $resourceArray
            ],
            $this->getStub('HttpResource')
        );


        if(!File::isDirectory(app_path("/Http/Resources"))){
            File::makeDirectory(app_path("/Http/Resources"), 0777, true);
        }

        $resourceDirPath = app_path("/Http/Resources/{$this->getUCFirst($this->name)}");

        if(!File::isDirectory($resourceDirPath)){
            File::makeDirectory($resourceDirPath, 0777, true);
        }

        $fileName = "$resourceDirPath/{$this->getUCFirst($this->name)}Resource.php";

        File::put($fileName,$resourceTemplate);


    }

    protected function generateResourceCollection()
    {

        $resourceCollection = "[\n\t\t\t'data'=>".ucfirst($this->name)."Resource::collection";
        $resourceCollection .= '($this->collection),';
        $resourceCollection .= "\n\t\t];";

        $resourceTemplate = str_replace(
            [
                '{{modelPluralUcFirstName}}',
                '{{modelUcFirstName}}',
                '{{collection}}'
            ],
            [
                $this->getUCFirstPlural($this->name),
                $this->getUCFirst($this->name),
                $resourceCollection
            ],
            $this->getStub('HttpResourceCollection')
        );

        if(!File::isDirectory(app_path("/Http/Resources"))){
            File::makeDirectory(app_path("/Http/Resources"), 0777, true);
        }

        $resourceDirPath = app_path("/Http/Resources/{$this->getUCFirst($this->name)}");

        if(!File::isDirectory($resourceDirPath)){
            File::makeDirectory($resourceDirPath, 0777, true);
        }

        $fileName = "$resourceDirPath/{$this->getUCFirstPlural($this->name)}Resource.php";

        File::put($fileName,$resourceTemplate);

    }
}