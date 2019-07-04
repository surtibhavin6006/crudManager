<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 12:55 PM
 */

namespace Maven\CrudManager\Console\Commands\Traits;
use Illuminate\Support\Facades\File;

trait GenerateRepository
{
    protected function generateRepository()
    {

        $createAttributes = '';
        $updateAttributes = '';

        foreach($this->fieldsTypesAndValidations as $fieldTypeAndValidation){
            $commonString = '$model->'.$fieldTypeAndValidation['fieldName'];
            $commonString .= '=$attributes';
            $commonString .= "['".$fieldTypeAndValidation['fieldName']."'] ?? ";

            $createAttributes .= $commonString."NULL;\n\t\t";
            $updateAttributes .= $commonString.'$model->'.$fieldTypeAndValidation['fieldName'].";\n\t\t";
        }


        $resourceTemplate = str_replace(
            [
                '{{modelNameUCFirst}}',
                '{{createAttributes}}',
                '{{updateAttributes}}'
            ],
            [
                $this->getUCFirst($this->name),
                $createAttributes,
                $updateAttributes
            ],
            $this->getStub('Repository')
        );

        if(!File::isDirectory(app_path("/Repositories"))){
            File::makeDirectory(app_path("/Repositories"), 0777, true);
        }

        $fileName = app_path("/Repositories/{$this->getUCFirst($this->name)}Repository.php");


        File::put($fileName,$resourceTemplate);

    }
}