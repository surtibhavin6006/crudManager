<?php

namespace Maven\CrudManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Maven\CrudManager\Console\Commands\Traits\GenerateController;
use Maven\CrudManager\Console\Commands\Traits\GenerateMigration;
use Maven\CrudManager\Console\Commands\Traits\GenerateModel;
use Maven\CrudManager\Console\Commands\Traits\GenerateRepository;
use Maven\CrudManager\Console\Commands\Traits\GenerateRequest;
use Maven\CrudManager\Console\Commands\Traits\GenerateResource;
use Maven\CrudManager\Console\Commands\Traits\GenerateRoute;
use Maven\CrudManager\Console\Commands\Traits\StringHelper;

class CrudGenerator extends Command
{

    use StringHelper,GenerateModel,GenerateController,GenerateMigration,GenerateResource,GenerateRepository,GenerateRequest,GenerateRoute;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD operations';


    protected $name = '';
    protected $fieldsTypesAndValidations = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->setModuleName();

        $needMoreFields = true;
        do {
            $this->getFieldTypeAndValidation();
            $needMoreFields = $this->confirm('Do you need more field?');
        } while($needMoreFields);

        $this->displayFields();


        $this->generateMigration();
        $this->generateResource();
        $this->generateResourceCollection();
        $this->generateRepository();
        $this->model();
        $this->controller();
        $this->request();
        $this->route();

    }

    protected function setModuleName()
    {
        $this->name = $this->ask('Module Name');
    }

    protected function getStub($type)
    {
        return File::get(__DIR__."/../../stubs/$type.stub");
    }

    protected function getFieldTypeAndValidation()
    {
        $fieldName = $this->ask('Please enter field name');
        $fieldType = $this->ask('Please enter field type');

        $this->fieldsTypesAndValidations[] = array(
            'fieldName' => $fieldName,
            'fieldType' => $fieldType,
        );
    }

    protected function displayFields()
    {
        $headers = ['Field','Type'];

        $this->table($headers, $this->fieldsTypesAndValidations);
    }

}
