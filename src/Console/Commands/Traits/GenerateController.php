<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 12:49 PM
 */

namespace Maven\CrudManager\Console\Commands\Traits;
use Illuminate\Support\Facades\File;

trait GenerateController
{
    protected function controller()
    {
        $createUpdateAttributes = '';

        foreach($this->fieldsTypesAndValidations as $fieldTypeAndValidation){
            $createUpdateAttributes .= '$attributes';
            $createUpdateAttributes .= "['".$fieldTypeAndValidation['fieldName']."'] = ";
            $createUpdateAttributes .= '$request->input';
            $createUpdateAttributes .= "('".$fieldTypeAndValidation['fieldName']."');\n\t\t";
        }

        $controllerTemplate = str_replace(
            [
                '{{modelNameUCFirst}}',
                '{{modelNamePluralUcFirst}}',
                '{{modelNameCamelCase}}',
                '{{storeAttributes}}',
                '{{updateAttributes}}',
            ],
            [
                ucfirst($this->name),
                $this->getUCFirstPlural($this->name),
                $this->getCamelCase($this->name),
                $createUpdateAttributes,
                $createUpdateAttributes,
            ],
            $this->getStub('Controller')
        );


        $controllerApiDirPath = app_path("/Http/Controllers/Api");

        if(!File::isDirectory($controllerApiDirPath)){
            File::makeDirectory($controllerApiDirPath, 0777, true);
        }

        $controllerPath = "{$controllerApiDirPath}/{$this->getUCFirst($this->name)}Controller.php";

        File::put($controllerPath, $controllerTemplate);
    }
}