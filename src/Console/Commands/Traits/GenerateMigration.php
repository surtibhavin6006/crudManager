<?php
/**
 * Created by PhpStorm.
 * User: bhavin
 * Date: 4/7/19
 * Time: 12:51 PM
 */

namespace Maven\CrudManager\Console\Commands\Traits;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

trait GenerateMigration
{
    protected function generateMigration()
    {
        $migrationArray = '';

        foreach($this->fieldsTypesAndValidations as $fieldTypeAndValidation){
            $migrationArray .= '$table->'.$fieldTypeAndValidation['fieldType'];
            $migrationArray .= "('".$fieldTypeAndValidation['fieldName']."');\n\t\t\t";
        }

        $migrationTemplate = str_replace(
            [
                '{{modelNamePluralLowerCase}}',
                '{{MigrationFields}}',
                '{{modelNamePluralUCFirst}}'
            ],
            [
                $this->getPluralLowerCase($this->name),
                $migrationArray,
                $this->getUCFirstPlural($this->name),
            ],
            $this->getStub('Migration')
        );

        $current_timestamp = Carbon::now()->timestamp;
        $fileName = Carbon::now()->format('Y_m_d_').$current_timestamp."_create_".$this->getPluralLowerCase($this->name)."_table.php";

        $migrationPath = database_path("/migrations/{$fileName}");

        File::put($migrationPath,$migrationTemplate);
    }
}