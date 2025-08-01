<?php declare(strict_types=1);

namespace Reference\Form;

use Common\Form\Element as CommonElement;
use Laminas\Form\Element;
use Laminas\Form\Fieldset;
use Omeka\Form\Element as OmekaElement;

class ReferenceTreeFieldset extends Fieldset
{
    /**
     * List of search configs  when module Advanced Search is used.
     *
     * @var array
     */
    protected $searchConfigs = [];

    public function init(): void
    {
        $this
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][fields]',
                'type' => OmekaElement\PropertySelect::class,
                'options' => [
                    'label' => 'Properties', // @translate
                    'term_as_value' => true,
                    'empty_option' => '',
                ],
                'attributes' => [
                    'id' => 'reference-tree-fields',
                    'required' => true,
                    'multiple' => true,
                    'class' => 'chosen-select',
                    'data-placeholder' => 'Select properties…', // @translate
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][tree]',
                'type' => Element\Textarea::class,
                'options' => [
                    'label' => 'Static tree of references', // @translate
                    'info' => 'Format is: one reference by line, preceded by zero, one or more "-" to indicate the hierarchy level.
Separate the "-" and the reference with a space. Empty lines are not considered.
Note: sql does case insensitive searches, so all references should be case-insensitively unique.', // @translate
                ],
                'attributes' => [
                    'id' => 'reference-tree-tree',
                    'required' => true,
                    'rows' => 12,
                    'cols' => 60,
                    'placeholder' => 'Europe
- France
-- Paris
- United Kingdom
-- England
--- London
Asia
- Japan
', // @translate
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][resource_name]',
                // TODO Radio doesn't work when there are multiple blocks.
                // 'type' => Element\Radio::class,
                'type' => Element\Select::class,
                'options' => [
                    'label' => 'Select resource', // @translate
                    'info' => 'Browse links are available only for item sets and items.',
                    'value_options' => [
                        // TODO Manage the list of reference separately.
                        // '' => 'All resources (separately)', // @translate
                        // 'resources' => 'All resources (together)',  // @translate
                        'item_sets' => 'Item sets',  // @translate
                        'items' => 'Items',  // @translate
                        // 'media' => 'Media',  // @translate
                    ],
                ],
                'attributes' => [
                    'id' => 'reference-tree-resource_name',
                    'required' => true,
                    'class' => 'chosen-select',
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][query]',
                'type' => OmekaElement\Query::class,
                'options' => [
                    'label' => 'Search pool query', // @translate
                    'info' => 'Restrict references to a particular subset of resources, for example a site.', // @translate
                    'query_resource_type' => null,
                    'query_partial_excludelist' => ['common/advanced-search/site'],
                ],
                'attributes' => [
                    'id' => 'reference-tree-query',
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][query_type]',
                // TODO Radio doesn't work when there are multiple blocks.
                // 'type' => Element\Radio::class,
                'type' => Element\Select::class,
                'options' => [
                    'label' => 'Query type', // @translate
                    'info' => 'The type of query defines how elements are regrouped (see the advanced search).', // @translate
                    'value_options' => [
                        'eq' => 'Is Exactly', // @translate
                        'in' => 'Contains', // @translate
                    ],
                ],
                'attributes' => [
                    'id' => 'reference-tree-query_type',
                    'class' => 'chosen-select',
                    'value' => 'eq',
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][search_config]',
                'type' => Element\Select::class,
                'options' => [
                    'label' => 'Link to browse or search engine', // @translate
                    'info' => 'This option is useful when the module Advanced Search is used.', // @translate
                    'value_options' => [
                        'default' => 'Search config of the site', // @translate
                    ] + $this->searchConfigs,
                    'empty_option' => '',
                ],
                'attributes' => [
                    'id' => 'reference-tree-search_config',
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][link_to_single]',
                'type' => Element\Checkbox::class,
                'options' => [
                    'label' => 'Direct link for single records', // @translate
                    'info' => 'When a reference has only one item, link to it directly instead of to the items/browse page.', // @translate
                ],
                'attributes' => [
                    'id' => 'reference-tree-link_to_single',
                ],
                'filters' => [
                    ['name' => \Laminas\Filter\Boolean::class],
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][custom_url]',
                'type' => Element\Checkbox::class,
                'options' => [
                    'label' => 'Custom url for single records', // @translate
                    'info' => 'May be set with modules such Clean Url or Ark. May slow the display when there are many single references.', // @translate
                ],
                'attributes' => [
                    'id' => 'reference-tree-custom_url',
                ],
                'filters' => [
                    ['name' => \Laminas\Filter\Boolean::class],
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][total]',
                'type' => Element\Checkbox::class,
                'options' => [
                    'label' => 'Add the total of resources for each reference', // @translate
                ],
                'attributes' => [
                    'id' => 'reference-tree-total',
                ],
                'filters' => [
                    ['name' => \Laminas\Filter\Boolean::class],
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][url_argument_reference]',
                'type' => Element\Checkbox::class,
                'options' => [
                    'label' => 'Append "reference" as argument to query urls for themes', // @translate
                ],
                'attributes' => [
                    'id' => 'reference-tree-url_argument_reference',
                ],
                'filters' => [
                    ['name' => \Laminas\Filter\Boolean::class],
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][thumbnail]',
                'type' => CommonElement\ThumbnailTypeSelect::class,
                'options' => [
                    'label' => 'Add the thumbnail of the first resource', // @translate
                    'empty_option' => '',
                ],
                'attributes' => [
                    'id' => 'reference-tree-thumbnail',
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][expanded]',
                'type' => Element\Checkbox::class,
                'options' => [
                    'label' => 'Expand the tree', // @translate
                ],
                'attributes' => [
                    'id' => 'reference-tree-expanded',
                ],
                'filters' => [
                    ['name' => \Laminas\Filter\Boolean::class],
                ],
            ])
            ->add([
                'name' => 'o:block[__blockIndex__][o:data][branch]',
                'type' => Element\Checkbox::class,
                'options' => [
                    'label' => 'Managed as branch', // @translate
                    'info' => 'Check this box if the tree is managed as branch (the path is saved with " :: " between each branch).', // @translate
                ],
                'attributes' => [
                    'id' => 'reference-tree-branch',
                ],
                'filters' => [
                    ['name' => \Laminas\Filter\Boolean::class],
                ],
            ]);
    }

    public function setSearchConfigs(array $searchConfigs): self
    {
        $this->searchConfigs = $searchConfigs;
        return $this;
    }
}
