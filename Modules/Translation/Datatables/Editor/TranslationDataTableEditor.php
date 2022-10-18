<?php

namespace Modules\Translation\Datatables\Editor;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;
use Modules\Translation\Entities\Translation;

class TranslationDataTableEditor extends DataTablesEditor
{
    protected $model = Translation::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'group' => Rule::requiredIf(request()->lang == default_language()),
            'key'   => Rule::requiredIf(request()->lang == default_language()),
            'text'  => 'required',
        ];
    }

    /**
     * Get edit action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function editRules(Model $model)
    {
        return [
            'group' => Rule::requiredIf(request()->lang == default_language()),
            'key'   => Rule::requiredIf(request()->lang == default_language()),
            'text'  => 'required',
        ];
    }

    /**
     * Get remove action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function removeRules(Model $model)
    {
        return [];
    }

    protected function createMessages()
    {
        return [
            'key.required'  => 'This field is required',
            'text.required' => 'This field is required',
        ];
    }

    protected function editMessages()
    {
        return [
            'key.required'  => 'This field is required',
            'text.required' => 'This field is required',
        ];
    }

    /**
     * Event hook that is fired before creating a new record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Empty model instance.
     * @param array $data Attribute values array received from Editor.
     * @return array The updated attribute values array.
     */
    public function creating(Model $model, array $data)
    {
        $model->setTranslation($data['lang'], $data['text']);

        $data['text'] = $model->text;

        return $data;
    }

    /**
     * Event hook that is fired before updating an existing record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Model instance retrived
     *  retrived from database.
     * @param array $data Attribute values array received from Editor.
     * @return array The updated attribute values array.
     */
    public function updating(Model $model, array $data)
    {
        $model->setTranslation($data['lang'], $data['text']);

        $data['text'] = $model->text;

        if (request()->lang != default_language()) {
            $data = Arr::except($data, 'key');
        }

        return $data;
    }

    /**
     * Event hook that is fired after deleting the record from database.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The original model
     *   retrieved from database.
     * @param array $data Attribute values array received from Editor.
     * @return void
     */
    public function deleted(Model $model, array $data)
    {
        // Record no longer exists in database, but $model instance still contains
        // data as it was before deleting. Any changes to the $model instance will
        // be returned to Editor.

        if (request()->lang != default_language()) {

            Translation::create([
                'namespace' => $model->namespace,
                'group'     => $model->group,
                'key'       => $model->key,
                'text'      => Arr::except($model->text, request()->lang),
            ]);
        }
    }
}
