<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Exceptions\NovaException;

class URL extends Text
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'url-field';

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|\Closure|callable|object|null  $attribute
     * @param  (callable(mixed, mixed, ?string):(mixed))|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, ?callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->textAlign(Field::CENTER_ALIGN);
    }

    /**
     * Resolve the field's value.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        $this->displayedAs = $this->name;

        parent::resolve($resource, $attribute);
    }

    /**
     * Allow the field to be copyable to the clipboard inside Nova.
     *
     * @return $this
     */
    public function copyable()
    {
        throw NovaException::helperNotSupported(__METHOD__, __CLASS__);
    }
}
