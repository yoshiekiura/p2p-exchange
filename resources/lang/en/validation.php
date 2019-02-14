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

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

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

    'phone' => 'The :attribute field contains an invalid number.',

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

    'attributes' => [
        'APP_NAME'           => 'App Name',
        'APP_REDIRECT_HTTPS' => 'Force SSL',
        'APP_TIMEZONE'       => 'Timezone',
        'APP_URL'            => 'App Url',
        'APP_DESCRIPTION'    => 'App Description',
        'APP_KEYWORDS'       => 'App Keywords',
        'APP_LOGO_ICON'      => 'App Logo Icon',
        'APP_SHORTCUT_ICON'  => 'App Shortcut Icon',
        'APP_LOGO_BRAND'     => 'App Logo Brand',

        'DB_CONNECTION' => 'Database Connection',
        'DB_HOST'       => 'Database Host',
        'DB_PORT'       => 'Database Port',
        'DB_DATABASE'   => 'Database Name',
        'DB_USERNAME'   => 'Database Username',
        'DB_PASSWORD'   => 'Database Password',

        'BROADCAST_DRIVER' => 'Broadcast Driver',

        'REDIS_HOST'     => 'Redis Host',
        'REDIS_PASSWORD' => 'Redis Password',
        'REDIS_PORT'     => 'Redis Port',

        'SET_DEFAULT_CURRENCY'     => 'Default Currency',
        'SET_TX_PREFERENCE'        => 'Preference',
        'SET_MIN_TX_CONFIRMATIONS' => 'Minimum Confirmations',
        'SET_TX_NUM_BLOCKS'        => 'Number of Blocks',

        'SET_BTC_TRADE_FEE'               => 'Bitcoin Trade Fee',
        'SET_BTC_PROFIT_PER_WALLET_LIMIT' => 'Bitcoin Profit Per Wallet Limit',
        'SET_BTC_LOCKED_BALANCE'          => 'Bitcoin Locked Balance',

        'SET_LTC_TRADE_FEE'               => 'Litecoin Trade Fee',
        'SET_LTC_PROFIT_PER_WALLET_LIMIT' => 'Litecoin Profit Per Wallet Limit',
        'SET_LTC_LOCKED_BALANCE'          => 'Litecoin Locked Balance',

        'SET_DASH_TRADE_FEE'               => 'Dash Trade Fee',
        'SET_DASH_PROFIT_PER_WALLET_LIMIT' => 'Dash Profit Per Wallet Limit',
        'SET_DASH_LOCKED_BALANCE'          => 'Dash Locked Balance',

        'MAIL_DRIVER'       => 'Email Driver',
        'MAIL_USERNAME'     => 'Email Username',
        'MAIL_PASSWORD'     => 'Email Password',
        'MAIL_ENCRYPTION'   => 'Email Encryption',
        'MAIL_HOST'         => 'Email Host',
        'MAIL_PORT'         => 'Email Port',
        'MAIL_FROM_ADDRESS' => 'Email From Address',
        'MAIL_FROM_NAME'    => 'Email From Name',

        'MAILGUN_DOMAIN' => 'Mailgun Domain',
        'MAILGUN_SECRET' => 'Mailgun Secret',

        'SPARKPOST_SECRET' => 'Sparkpost Secret',

        'SES_KEY'    => 'Ses Key',
        'SES_SECRET' => 'Ses Secret',
        'SES_REGION' => 'Ses Region',

        'PUSHER_APP_ID'      => 'Pusher Id',
        'PUSHER_APP_CLUSTER' => 'Pusher Cluster',
        'PUSHER_APP_KEY'     => 'Pusher Key',
        'PUSHER_APP_SECRET'  => 'Pusher Secret',

        'NOCAPTCHA_ENABLE'  => 'Nocaptcha Enable',
        'NOCAPTCHA_SECRET'  => 'Nocaptcha Secret',
        'NOCAPTCHA_SITEKEY' => 'Nocaptcha Sitekey',
        'NOCAPTCHA_TYPE'    => 'Nocaptcha Type',

        'SMS_PROVIDER' => 'Sms Provider',

        'NEXMO_KEY'    => 'Naxmo Key',
        'NEXMO_SECRET' => 'Naxmo Secret',
        'NEXMO_PHONE'  => 'Naxmo Phone',

        'AFRICASTALKING_USERNAME' => 'AfricasTalking Username',
        'AFRICASTALKING_KEY'      => 'AfricasTalking Key',
        'AFRICASTALKING_FROM'     => 'AfricasTalking From',
        'AFRICASTALKING_ENQUEUE'  => 'AfricasTalking Enqueue',

        'BITGO_ENV'   => 'Bitgo Env',
        'BITGO_TOKEN' => 'Bitgo Token',
        'BITGO_HOST'  => 'Bitgo Host',
        'BITGO_PORT'  => 'Bitgo Port',
    ],

];
