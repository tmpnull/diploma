<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute должен быть подтвержден.',
    'active_url'           => ':attribute не правильный URL.',
    'after'                => ':attribute должна быть датой больше :date.',
    'after_or_equal'       => ':attribute должна быть больше или равной :date.',
    'alpha'                => ':attribute должен содержать только буквы.',
    'alpha_dash'           => ':attribute должен содержать буквы, числа и дефизы.',
    'alpha_num'            => ':attribute должен содержать буквы и числа.',
    'array'                => ':attribute должен быть массивом.',
    'before'               => ':attribute должна быть меньше :date.',
    'before_or_equal'      => ':attribute должна быть меньше или равной :date.',
    'between'              => [
        'numeric' => ':attribute должен быть между :min и :max.',
        'file'    => ':attribute должен быть между :min и :max килобайт.',
        'string'  => ':attribute должен быть между :min и :max символов.',
        'array'   => ':attribute должен быть между :min и :max элементов.',
    ],
    'boolean'              => ':attribute поле должно быть true или false.',
    'confirmed'            => ':attribute утверждение не совпадает.',
    'date'                 => ':attribute некорректная дата.',
    'date_format'          => ':attribute не совпадает формат :format.',
    'different'            => ':attribute and :other должно быть различным.',
    'digits'               => ':attribute должно быть :digits чисел.',
    'digits_between'       => ':attribute должно быть между :min и :max числом.',
    'dimensions'           => ':attribute содержит неправильное соотношение.',
    'distinct'             => ':attribute поле содаржеит дупликат.',
    'email'                => ':attribute должно быть корректным email адрессом.',
    'exists'               => 'Выбранный :attribute неверен.',
    'file'                 => ':attribute должно быть файлом.',
    'filled'               => ':attribute поле должно содержать значение.',
    'image'                => ':attribute должно быть изображением.',
    'in'                   => 'Выбранный :attribute неверен.',
    'in_array'             => ':attribute поле не содержится в :other.',
    'integer'              => ':attribute должно быть целым числом.',
    'ip'                   => ':attribute должно быть корректным IP адрессом.',
    'ipv4'                 => ':attribute должно быть корректным IPv4 адрессом.',
    'ipv6'                 => ':attribute должно быть корректным IPv6 адрессом.',
    'json'                 => ':attribute должно быть корректной JSON строкой.',
    'max'                  => [
        'numeric' => ':attribute не может больше чем :max.',
        'file'    => ':attribute не может больше чем :max килобайт.',
        'string'  => ':attribute не может больше чем :max символов.',
        'array'   => ':attribute не может содержать больше чем :max элементов.',
    ],
    'mimes'                => ':attribute должно быть файлом типа: :values.',
    'mimetypes'            => ':attribute должно быть файлом типа: :values.',
    'min'                  => [
        'numeric' => ':attribute должно быть at least :min.',
        'file'    => ':attribute должно быть at least :min kilobytes.',
        'string'  => ':attribute должно быть at least :min characters.',
        'array'   => ':attribute must have at least :min items.',
    ],
    'not_in'               => 'Выбранный :attribute неверен.',
    'not_regex'            => ':attribute формат неверен.',
    'numeric'              => ':attribute должно быть числом.',
    'present'              => ':attribute поле должно быть передано.',
    'regex'                => ':attribute формат неверен.',
    'required'             => ':attribute поле обязательно.',
    'required_if'          => ':attribute поле обязательно если :other равно :value.',
    'required_unless'      => ':attribute поле обязательно если :other не равно :values.',
    'required_with'        => ':attribute поле обязательно когда :values передано.',
    'required_with_all'    => ':attribute поле обязательно когда :values передано.',
    'required_without'     => ':attribute поле обязательно когда :values не передано.',
    'required_without_all' => ':attribute поле обязательно когда ниодно из :values не передано.',
    'same'                 => ':attribute м :other должны совпадать.',
    'size'                 => [
        'numeric' => ':attribute должен быть :size.',
        'file'    => ':attribute должен быть :size килобайт.',
        'string'  => ':attribute должен содеражть :size символов.',
        'array'   => ':attribute должен содержать :size элементов.',
    ],
    'string'               => ':attribute должен быть строкой.',
    'timezone'             => ':attribute должен быть валидным часовым поясом.',
    'unique'               => ':attribute уже используется.',
    'uploaded'             => ':attribute не может быть загружн.',
    'url'                  => 'Формат :attribute не правильный.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
