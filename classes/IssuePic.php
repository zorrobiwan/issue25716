<?php

class IssuePic extends ObjectModel
{

    public $id_issue25716;
    public $name;
    public $picture;

    public static $definition = [
        'table' => 'issue25716',
        'primary' => 'id_issue25716',
        'fields' =>
        [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isAnything', 'required' => true],
            'picture' => ['type' => FileType::class, 'validate' => 'isAnything'],
        ],
    ];
}
