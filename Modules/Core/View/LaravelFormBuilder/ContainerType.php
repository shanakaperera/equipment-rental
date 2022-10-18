<?php

namespace Modules\Core\View\LaravelFormBuilder;

use Kris\LaravelFormBuilder\Fields\ParentType;

class ContainerType extends ParentType
{
    protected function getTemplate()
    {
        return 'core::laravel-form-builder.container';
    }

    /**
     * @return mixed|void
     * @throws \Exception
     */
    protected function createChildren()
    {
        $this->children = [];
        $fields = $this->getOption('fields');
        $requiredOptions = ['type', 'name'];

        foreach ($fields as $field) {
            foreach ($requiredOptions as $requiredOption) {
                if (empty($field[$requiredOption])) {
                    throw new \Exception("Fields field [{$this->name}] requires [{$requiredOption}] option");
                }
            }

            $type = $field['type'];
            $name = $field['name'];
            $options = $field['options'] ?? [];
            $fieldType = $this->formHelper->getFieldType($type);
            $parentName = $this->getParent()->getName();
            $field = new $fieldType($parentName ? "{$parentName}[{$name}]" : $name, $type, $this->parent, $options);
            $this->children[] = $field;
        }
    }

    /**
     * @inheritdoc
     */
    public function getAllAttributes()
    {
        return $this->formHelper->mergeAttributes($this->children);
    }

    /**
     * @inheritdoc
     */
    public function getValidationRules()
    {
        return $this->formHelper->mergeFieldsRules($this->children);
    }
}
