<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MonsterRequest as StoreRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MonsterRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class MonsterCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Monster');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/monster');
        $this->crud->setEntityNameStrings('monster', 'monsters');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS
        // $this->crud->addColumn('text'); // add a text column, at the end of the stack
        // $this->crud->addColumn('email'); // add a single column, at the end of the stack
        // $this->crud->addColumn('textarea'); // add a single column, at the end of the stack
        $this->crud->addColumns([
            'text',
            'textarea',
            [
                'name'  => 'image', // The db column name
                'label' => 'Image', // Table column heading
                'type'  => 'image',
                // 'prefix' => 'folder/subfolder/',
                // optional width/height if 25px is not ok with you
                // 'height' => '30px',
                // 'width' => '30px',
            ],
            [
                'name'  => 'base64_image', // The db column name
                'label' => 'Base64 Image', // Table column heading
                'type'  => 'image',
                // 'prefix' => 'folder/subfolder/',
                // optional width/height if 25px is not ok with you
                // 'height' => '30px',
                // 'width' => '30px',
            ],
            [
                'name'  => 'checkbox',
                'label' => 'Boolean',
                'type'  => 'boolean',
                // optionally override the Yes/No texts
                'options' => [0 => 'Yes', 1 => 'No'],
            ],
            [
               'name'  => 'checkbox', // The db column name
               'key'   => 'check',
               'label' => 'Agreed', // Table column heading
               'type'  => 'check',
            ],
            [
                'name'     => 'created_at',
                'label'    => 'Created At',
                'type'     => 'closure',
                'function' => function ($entry) {
                    return 'Created on '.$entry->created_at;
                },
            ],
            [
               'name'  => 'name', // The db column name
               'label' => 'Date', // Table column heading
               'type'  => 'date',
                // 'format' => 'l j F Y', // use something else than the base.default_date_format config value
            ],
            [
               'name'  => 'name', // The db column name
               'label' => 'Datetime', // Table column heading
               'type'  => 'datetime',
                // 'format' => 'l j F Y H:i:s', // use something else than the base.default_datetime_format config value
            ],
            [
               'name'  => 'email', // The db column name
               'label' => 'Email Address', // Table column heading
               'type'  => 'email',
               // 'limit' => 500, // if you want to truncate the text to a different number of characters
            ],
            [
               // show both text and email values in one column
               // this column is here to demo and test the custom searchLogic functionality
               'name'          => 'model_function',
               'label'         => 'Text and Email', // Table column heading
               'type'          => 'model_function',
               'function_name' => 'getTextAndEmailAttribute', // the method in your Model
               'searchLogic'   => function ($query, $column, $searchTerm) {
                   $query->orWhere('email', 'like', '%'.$searchTerm.'%');
                   $query->orWhere('text', 'like', '%'.$searchTerm.'%');
               },
            ],
            [
               'name'  => 'number', // The db column name
               'label' => 'Number', // Table column heading
               'type'  => 'number',
               // 'prefix' => "$",
               // 'suffix' => " EUR",
               // 'decimals' => 2,
               // 'dec_point' => ',',
               // 'thousands_sep' => '.',
               // decimals, dec_point and thousands_sep are used to format the number;
               // for details on how they work check out PHP's number_format() method, they're passed directly to it;
               // https://www.php.net/manual/en/function.number-format.php
            ],
            [
                'name'        => 'radio',
                'label'       => 'Radio',
                'type'        => 'radio',
                'options'     => [0 => 'Draft', 1 => 'Published', 2 => 'Other'],
            ],
            [
               // 1-n relationship
               'label'     => 'Select', // Table column heading
               'type'      => 'select',
               'name'      => 'select', // the column that contains the ID of that connected entity;
               'entity'    => 'category', // the method that defines the relationship in your Model
               'attribute' => 'name', // foreign key attribute that is shown to user
               'model'     => "Backpack\NewsCRUD\app\Models\Category", // foreign key model
            ],
            [ // select_from_array
                'name'    => 'Select_from_array',
                'label'   => 'Status',
                'type'    => 'select_from_array',
                'options' => ['one' => 'One', 'two' => 'Two', 'three' => 'Three'],
            ],
            [
               // select_multiple: n-n relationship (with pivot table)
               'label'     => 'Select_multiple', // Table column heading
               'type'      => 'select_multiple',
               'name'      => 'tags', // the method that defines the relationship in your Model
               'entity'    => 'tags', // the method that defines the relationship in your Model
               'attribute' => 'name', // foreign key attribute that is shown to user
               'model'     => "Backpack\NewsCRUD\app\Models\Tag", // foreign key model
            ],
            [
               'name'  => 'video', // The db column name
               'label' => 'Video', // Table column heading
               'type'  => 'video',
            ],
        ]);
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // -------------------------
        // ------ CRUD FIELDS ------
        // -------------------------

        // ----------
        // SIMPLE tab
        // ----------
        $this->crud->addField([
            'name'  => 'text',
            'label' => 'Text',
            'type'  => 'text',
            'tab'   => 'Simple',
        ]);

        $this->crud->addField([
            'name'  => 'email',
            'label' => 'Email',
            'type'  => 'email',
            'tab'   => 'Simple',
        ]);

        $this->crud->addField([   // Textarea
            'name'  => 'textarea',
            'label' => 'Textarea',
            'type'  => 'textarea',
            'tab'   => 'Simple',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'number',
            'label' => 'Number',
            'type'  => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            // 'prefix' => "$",
            // 'suffix' => ".00",
            'tab' => 'Simple',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'float',
            'label' => 'Float',
            'type'  => 'number',
            // optionals
            'attributes' => ['step' => 'any'], // allow decimals
            // 'prefix' => "$",
            // 'suffix' => ".00",
            'tab' => 'Simple',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'number_with_prefix',
            'label' => 'Number with prefix',
            'type'  => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            'prefix' => '$',
            // 'suffix' => ".00",
            'fake'     => true,
            'store_in' => 'extras',
            'tab'      => 'Simple',
        ]);

        $this->crud->addField([   // Number
            'name'  => 'number_with_suffix',
            'label' => 'Number with suffix',
            'type'  => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            // 'prefix' => "$",
            'suffix'   => '.00',
            'fake'     => true,
            'store_in' => 'extras',
            'tab'      => 'Simple',
        ]);

        $this->crud->addField([   // Number
            'name'     => 'text_with_both_prefix_and_suffix',
            'label'    => 'Text with both prefix and suffix',
            'type'     => 'number',
            'prefix'   => '@',
            'suffix'   => "<i class='fa fa-home'></i>",
            'fake'     => true,
            'store_in' => 'extras',
            'tab'      => 'Simple',
        ]);

        $this->crud->addField([   // Password
            'name'  => 'password',
            'label' => 'Password',
            'type'  => 'password',
            'tab'   => 'Simple',
        ]);

        $this->crud->addField([
            'name'    => 'radio', // the name of the db column
            'label'   => 'Status (radio)', // the input label
            'type'    => 'radio',
            'options' => [ // the key will be stored in the db, the value will be shown as label;
                                0 => 'Draft',
                                1 => 'Published',
                                2 => 'Other',
                            ],
            // optional
            'inline' => true, // show the radios all on the same line?
            'tab'    => 'Simple',
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'checkbox',
            'label' => 'I have not read the terms and conditions and I never will (checkbox)',
            'type'  => 'checkbox',
            'tab'   => 'Simple',
        ]);

        $this->crud->addField([   // Hidden
            'name'    => 'hidden',
            'type'    => 'hidden',
            'default' => 'hidden value',
            'tab'     => 'Simple',
        ]);

        // -----------------
        // DATE, TIME AND SPACE tab
        // -----------------

        $this->crud->addField([   // Month
            'name'  => 'week',
            'label' => 'Week',
            'type'  => 'week',
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Time and space',
        ]);

        $this->crud->addField([   // Month
            'name'  => 'month',
            'label' => 'Month',
            'type'  => 'month',
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Time and space',
        ]);

        $this->crud->addField([   // Date
            'name'       => 'date',
            'label'      => 'Date (HTML5 spec)',
            'type'       => 'date',
            'attributes' => [
                'pattern'     => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
                'placeholder' => 'yyyy-mm-dd',
            ],
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Time and space',
        ]);

        $this->crud->addField([   // Date
            'name'  => 'date_picker',
            'label' => 'Date (jQuery plugin)',
            'type'  => 'date_picker',
            // optional:
            'date_picker_options' => [
                'todayBtn' => true,
                'format'   => 'dd-mm-yyyy',
                'language' => 'en',
            ],
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Time and space',
        ]);

        $this->crud->addField([   // DateTime
            'name'  => 'datetime',
            'label' => 'Datetime (HTML5 spec)',
            'type'  => 'datetime',
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Time and space',
        ]);

        $this->crud->addField([   // DateTime
            'name'  => 'datetime_picker',
            'label' => 'Datetime picker (jQuery plugin)',
            'type'  => 'datetime_picker',
            // optional:
            'datetime_picker_options' => [
                'format'   => 'DD/MM/YYYY HH:mm',
                'language' => 'en',
            ],
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Time and space',
        ]);

        $this->crud->addField([ // Date_range
            'name'       => 'date_range', // a unique name for this field
            'start_name' => 'start_date', // the db column that holds the start_date
            'end_name'   => 'end_date', // the db column that holds the end_date
            'label'      => 'Date Range',
            'type'       => 'date_range',
            // OPTIONALS
            'start_default'      => '2017-03-28 01:01', // default value for start_date
            'end_default'        => '2017-04-05 02:00', // default value for end_date
            'date_range_options' => [ // options sent to daterangepicker.js
                'timePicker' => true,
                'locale'     => ['format' => 'DD/MM/YYYY HH:mm'],
            ],
            'tab' => 'Time and space',
        ]);

        $this->crud->addField([   // Address
            'name'  => 'address',
            'label' => 'Address (Algolia Places search)',
            'type'  => 'address',
            // optional
            'store_as_json' => true,
            'tab'           => 'Time and space',
        ], 'both'); // the second parameter for the addField method is the form it should place this field in; specify either 'create', 'update' or 'both'; default is 'both', so you might aswell not mention it;

        // -----------------
        // SELECTS tab
        // -----------------

        $this->crud->addField([    // SELECT
            'label'     => 'Select (1-n relationship)',
            'type'      => 'select',
            'name'      => 'select',
            'entity'    => 'category',
            'attribute' => 'name',
            'model'     => "Backpack\NewsCRUD\app\Models\Category",
            'tab'       => 'Selects',
        ]);

        $this->crud->addField([       // Select_Multiple = n-n relationship
            'label'     => 'Select_multiple (n-n relationship with pivot table)',
            'type'      => 'select_multiple',
            'name'      => 'tags', // the method that defines the relationship in your Model
            'entity'    => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "Backpack\NewsCRUD\app\Models\Tag", // foreign key model
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            'tab'       => 'Selects',
        ]);

        $this->crud->addField([ // select_from_array
            'name'            => 'select_from_array',
            'label'           => 'Select_from_array (no relationship, 1-1 or 1-n)',
            'type'            => 'select_from_array',
            'options'         => ['one' => 'One', 'two' => 'Two', 'three' => 'Three'],
            'allows_null'     => true,
            'tab'             => 'Selects',
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([    // SELECT2
            'label'         => 'Select2 (1-n relationship)',
            'type'          => 'select2',
            'name'          => 'select2',
            'entity'        => 'category',
            'attribute'     => 'name',
            'model'         => "Backpack\NewsCRUD\app\Models\Category",
            'tab'           => 'Selects',
        ]);

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label'         => 'Select2_multiple (n-n relationship with pivot table)',
            'type'          => 'select2_multiple',
            'name'          => 'categories', // the method that defines the relationship in your Model
            'entity'        => 'categories', // the method that defines the relationship in your Model
            'attribute'     => 'name', // foreign key attribute that is shown to user
            'model'         => "Backpack\NewsCRUD\app\Models\Category", // foreign key model
            'allows_null'   => true,
            'pivot'         => true, // on create&update, do you need to add/delete pivot table entries?
            'tab'           => 'Selects',
        ]);

        $this->crud->addField([ // select2_from_array
            'name'            => 'select2_from_array',
            'label'           => 'Select2_from_array (no relationship, 1-1 or 1-n)',
            'type'            => 'select2_from_array',
            'options'         => ['one' => 'One', 'two' => 'Two', 'three' => 'Three'],
            'allows_null'     => true,
            'tab'             => 'Selects',
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([ // select2_from_ajax: 1-n relationship
            'label'                => "Article <small class='font-light'>(select2_from_ajax for a 1-n relationship)</small>", // Table column heading
            'type'                 => 'select2_from_ajax',
            'name'                 => 'select2_from_ajax', // the column that contains the ID of that connected entity;
            'entity'               => 'article', // the method that defines the relationship in your Model
            'attribute'            => 'title', // foreign key attribute that is shown to user
            'model'                => "Backpack\NewsCRUD\app\Models\Article", // foreign key model
            'data_source'          => url('api/article'), // url to controller search function (with /{id} should return model)
            'placeholder'          => 'Select an article', // placeholder for the select
            'minimum_input_length' => 2, // minimum characters to type before querying results
            'tab'                  => 'Selects',
        ]);

        $this->crud->addField([ // Select2_from_ajax_multiple: n-n relationship with pivot table
            'label'                => "Articles <small class='font-light'>(select2_from_ajax_multiple for an n-n relationship with pivot table)</small>", // Table column heading
            'type'                 => 'select2_from_ajax_multiple',
            'name'                 => 'articles', // the column that contains the ID of that connected entity;
            'entity'               => 'articles', // the method that defines the relationship in your Model
            'attribute'            => 'title', // foreign key attribute that is shown to user
            'model'                => "Backpack\NewsCRUD\app\Models\Article", // foreign key model
            'data_source'          => url('api/article'), // url to controller search function (with /{id} should return model)
            'placeholder'          => 'Select one or more articles', // placeholder for the select
            'minimum_input_length' => 2, // minimum characters to type before querying results
            'pivot'                => true, // on create&update, do you need to add/delete pivot table entries?
            'tab'                  => 'Selects',
        ]);

        $this->crud->addField([ // select_and_order
            'name'    => 'select_and_order',
            'label'   => 'Featured',
            'type'    => 'select_and_order',
            'options' => [
                1 => 'Option 1',
                2 => 'Option 2',
                3 => 'Option 3',
                4 => 'Option 4',
                5 => 'Option 5',
                6 => 'Option 6',
                7 => 'Option 7',
                8 => 'Option 8',
                9 => 'Option 9',
            ],
            'fake' => true,
            'tab'  => 'Selects',
        ]);

        // -----------------
        // UPLOADS tab
        // -----------------
        $this->crud->addField([   // Browse
            'name'  => 'browse',
            'label' => 'Browse (using elFinder)',
            'type'  => 'browse',
            'tab'   => 'Uploads',
        ]);

        $this->crud->addField([ // base64_image
            'label'        => 'Base64 Image - includes cropping',
            'name'         => 'base64_image',
            'filename'     => null, // set to null if not needed
            'type'         => 'base64_image',
            'aspect_ratio' => 1, // set to 0 to allow any aspect ratio
            'crop'         => true, // set to true to allow cropping, false to disable
            'src'          => null, // null to read straight from DB, otherwise set to model accessor function
            'tab'          => 'Uploads',
        ]);

        $this->crud->addField([ // image
            'label'        => 'Image',
            'name'         => 'image',
            'type'         => 'image',
            'upload'       => true,
            'crop'         => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
            // 'disk' => config('backpack.base.root_disk_name'), // in case you need to show images from a different disk
            // 'prefix' => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            'tab' => 'Uploads',
        ]);

        // $table->string('image')->nullable;
        // $table->string('upload')->nullable;
        // $table->string('upload_multiple')->nullable;

        // -----------------
        // BIG TEXTS tab
        // -----------------
        $this->crud->addField([   // SimpleMDE
            'name'  => 'simplemde',
            'label' => 'SimpleMDE - markdown editor',
            'type'  => 'simplemde',
            'tab'   => 'Big texts',
        ]);

        $this->crud->addField([   // Summernote
            'name'  => 'summernote',
            'label' => 'Summernote editor',
            'type'  => 'summernote',
            'tab'   => 'Big texts',
        ]);

        $this->crud->addField([   // CKEditor
            'name'  => 'wysiwyg',
            'label' => 'CKEditor - also called the WYSIWYG field',
            'type'  => 'ckeditor',
            'tab'   => 'Big texts',
        ]);

        $this->crud->addField([   // TinyMCE
            'name'  => 'tinymce',
            'label' => 'TinyMCE',
            'type'  => 'tinymce',
            'tab'   => 'Big texts',
        ]);

        // -----------------
        // MISCELLANEOUS tab
        // -----------------
        $this->crud->addField([   // Color
            'name'  => 'color',
            'label' => 'Color picker (HTML5 spec)',
            'type'  => 'color',
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Miscellaneous',
        ]);
        $this->crud->addField([   // Color
            'name'  => 'color_picker',
            'label' => 'Color picker (jQuery plugin)',
            'type'  => 'color_picker',
            // 'wrapperAttributes' => ['class' => 'col-md-6'],
            'tab' => 'Miscellaneous',
        ]);

        $this->crud->addField([
            'label'   => 'Icon Picker',
            'name'    => 'icon_picker',
            'type'    => 'icon_picker',
            'iconset' => 'fontawesome', // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
            'tab'     => 'Miscellaneous',
        ]);

        $this->crud->addField([ // Table
            'name'            => 'table',
            'label'           => 'Table',
            'type'            => 'table',
            'entity_singular' => 'subentry', // used on the "Add X" button
            'columns'         => [
                'name'  => 'Name',
                'desc'  => 'Description',
                'price' => 'Price',
            ],
            'max' => 5, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table
            'tab' => 'Miscellaneous',
        ]);

        $this->crud->addField([ // Table
            'name'            => 'fake_table',
            'label'           => 'Fake Table',
            'type'            => 'table',
            'entity_singular' => 'subentry', // used on the "Add X" button
            'columns'         => [
                'name'  => 'Name',
                'desc'  => 'Description',
                'price' => 'Price',
            ],
            'fake' => true,
            'max'  => 5, // maximum rows allowed in the table
            'min'  => 0, // minimum rows allowed in the table
            'tab'  => 'Miscellaneous',
        ]);

        // $table->string('url')->nullable;
        // $table->text('video')->nullable;
        $this->crud->addField([   // URL
            'name'  => 'video',
            'label' => 'Video - link to video file on Youtube or Vimeo',
            'type'  => 'video',
        ]);
        // $table->string('range')->nullable;

        // $this->crud->removeField('name', 'update/create/both');

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        $this->crud->addButtonFromModelFunction('line', 'open_google', 'openGoogle', 'beginning'); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD DETAILS ROW
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        $this->crud->setDetailsRowView('vendor.backpack.crud.details_row.monster');

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.

        $this->crud->enableBulkActions();
        $this->crud->addBulkDeleteButton();
        $this->crud->enableExportButtons();

        // ------ FILTERS
        $this->addCustomCrudFilters();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function addCustomCrudFilters()
    {
        $this->crud->addFilter([ // add a "simple" filter called Draft
          'type'  => 'simple',
          'name'  => 'checkbox',
          'label' => 'Simple',
        ],
        false, // the simple filter has no values, just the "Draft" label specified above
        function () { // if the filter is active (the GET parameter "draft" exits)
            $this->crud->addClause('where', 'checkbox', '1');
        });

        $this->crud->addFilter([ // dropdown filter
          'name' => 'select_from_array',
          'type' => 'dropdown',
          'label'=> 'Dropdown',
        ], ['one' => 'One', 'two' => 'Two', 'three' => 'Three'], function ($value) {
            // if the filter is active
            $this->crud->addClause('where', 'select_from_array', $value);
        });

        $this->crud->addFilter([ // text filter
          'type'  => 'text',
          'name'  => 'text',
          'label' => 'Text',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'text', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([
          'name'       => 'number',
          'type'       => 'range',
          'label'      => 'Range',
          'label_from' => 'min value',
          'label_to'   => 'max value',
        ],
        false,
        function ($value) { // if the filter is active
            $range = json_decode($value);
            if ($range->from && $range->to) {
                $this->crud->addClause('where', 'number', '>=', (float) $range->from);
                $this->crud->addClause('where', 'number', '<=', (float) $range->to);
            }
        });

        $this->crud->addFilter([ // date filter
          'type'  => 'date',
          'name'  => 'date',
          'label' => 'Date',
        ],
        false,
        function ($value) { // if the filter is active, apply these constraints
            $this->crud->addClause('where', 'date', '=', $value);
        });

        $this->crud->addFilter([ // daterange filter
           'type' => 'date_range',
           'name' => 'date_range',
           'label'=> 'Date range',
           // 'date_range_options' => [
                 // 'format' => 'YYYY/MM/DD',
                 // 'locale' => ['format' => 'YYYY/MM/DD'],
                 // 'showDropdowns' => true,
                 // 'showWeekNumbers' => true
            // ]
         ],
         false,
         function ($value) { // if the filter is active, apply these constraints
             $dates = json_decode($value);
             $this->crud->addClause('where', 'date', '>=', $dates->from);
             $this->crud->addClause('where', 'date', '<=', $dates->to);
         });

        $this->crud->addFilter([ // select2 filter
          'name' => 'select2',
          'type' => 'select2',
          'label'=> 'Select2',
        ], function () {
            return \Backpack\NewsCRUD\app\Models\Category::all()->keyBy('id')->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'select2', $value);
        });

        $this->crud->addFilter([ // select2_multiple filter
          'name' => 'select2_multiple',
          'type' => 'select2_multiple',
          'label'=> 'Select2 multiple',
        ], function () {
            return \Backpack\NewsCRUD\app\Models\Category::all()->keyBy('id')->pluck('name', 'id')->toArray();
        }, function ($values) { // if the filter is active
            foreach (json_decode($values) as $key => $value) {
                $this->crud->addClause('orWhere', 'select2', $value);
            }
        });

        $this->crud->addFilter([ // select2_ajax filter
          'name'        => 'select2_from_ajax',
          'type'        => 'select2_ajax',
          'label'       => 'Select2 Ajax',
          'placeholder' => 'Pick an article',
        ],
        url('api/article-search'), // the ajax route
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'select2_from_ajax', $value);
        });
    }
}
