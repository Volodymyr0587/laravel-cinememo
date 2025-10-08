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

    'accepted' => 'Поле :attribute має бути прийняте.',
    'accepted_if' => 'Поле :attribute має бути прийнято, коли :other має значення :value.',
    'active_url' => 'Поле :attribute має бути дійсною URL-адресою.',
    'after' => 'Поле :attribute має бути датою після :date.',
    'after_or_equal' => 'Поле :attribute має бути датою, що дорівнює або наступна за :date.',
    'alpha' => 'Поле :attribute має містити лише літери.',
    'alpha_dash' => 'Поле :attribute повинно містити лише літери, цифри, дефіси та символи підкреслення.',
    'alpha_num' => 'Поле :attribute повинно містити лише літери та цифри.',
    'any_of' => 'Поле :attribute недійсне.',
    'array' => 'Поле :attribute має бути масивом.',
    'ascii' => 'Поле :attribute повинно містити лише однобайтові буквено-цифрові символи та символи.',
    'before' => 'Поле :attribute має бути датою, що передує :date.',
    'before_or_equal' => 'Поле :attribute має бути датою, що передує або дорівнює :date.',
    'між' => [
    'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
    'file' => 'Розмір поля :attribute має бути між :min та :max кілобайтами.',
    'numeric' => 'Поле :attribute має бути в межах від :min до :max.',
    'string' => 'Поле :attribute має містити від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute має бути true або false.',
    'can' => 'Поле :attribute містить неавторизоване значення.',
    'confirmed' => 'Поле підтвердження :attribute не збігається.',
    'contains' => 'У полі :attribute відсутнє обов\'язкове значення.',
    'current_password' => 'Пароль неправильний.',
    'date' => 'Поле :attribute має бути дійсною датою.',
    'date_equals' => 'Поле :attribute має бути датою, що дорівнює :date.',
    'date_format' => 'Поле :attribute має відповідати формату :format.',
    'decimal' => 'Поле :attribute повинно мати :decimal десяткових знаків.',
    'declined' => 'Поле :attribute має бути відхилено.',
    'declined_if' => 'Поле :attribute має бути відхилено, якщо :other має значення :value.',
    'different' => 'Поля :attribute та :other мають відрізнятися.',
    'digits' => 'Поле :attribute має бути :digits цифри.',
    'digits_between' => 'Поле :attribute має бути в межах від :min до :max цифр.',
    'dimensions' => 'Поле :attribute містить недійсні розміри зображення.',
    'distinct' => 'Поле :attribute має дублікат значення.',
    'doesnt_end_with' => 'Поле :attribute не повинно закінчуватися одним із наступних значень: :values.',
    'doesnt_start_with' => 'Поле :attribute не повинно починатися з одного з наступних: :values.',
    'email' => 'Поле :attribute має бути дійсною адресою електронної пошти.',
    'ends_with' => 'Поле :attribute має закінчуватися одним із наступних значень: :values.',
    'enum' => 'Вибраний :attribute недійсний.',
    'exists' => 'Вибраний :attribute недійсний.',
    'extensions' => 'Поле :attribute повинно мати одне з наступних розширень: :values.',
    'file' => 'Поле :attribute має бути файлом.',
    'filled' => 'Поле :attribute має містити значення.',
    'gt' => [
    'array' => 'Поле :attribute повинно містити більше ніж :value елементів.',
    'file' => 'Розмір поля :attribute має бути більшим за :value кілобайт.',
    'numeric' => 'Поле :attribute має бути більшим за :value.',
    'string' => 'Поле :attribute має бути більшим за :value символів.',
    ],
    'gte' => [
    'array' => 'Поле :attribute повинно містити елементи типу :value або більше.',
    'file' => 'Розмір поля :attribute має бути більшим або рівним :value кілобайтам.',
    'numeric' => 'Поле :attribute має бути більшим або рівним :value.',
    'string' => 'Поле :attribute має бути більшим або рівним символам :value.',
    ],
    'hex_color' => 'Поле :attribute має бути дійсним шістнадцятковим кольором.',
    'image' => 'Поле :attribute має бути зображенням.',
    'in' => 'Вибраний :attribute недійсний.',
    'in_array' => 'Поле :attribute має існувати в :other.',
    'in_array_keys' => 'Поле :attribute повинно містити принаймні один з наступних ключів: :values.',
    'integer' => 'Поле :attribute має бути цілим числом.',
    'ip' => 'Поле :attribute має бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute має бути дійсною IPv4-адресою.',
    'ipv6' => 'Поле :attribute має бути дійсною IPv6-адресою.',
    'json' => 'Поле :attribute має бути дійсним рядком JSON.',
    'список' => 'Поле :attribute має бути списком.',
    'lowercase' => 'Поле :attribute має бути введено літерами нижнього регістру.',
    'лт' => [
    'array' => 'Поле :attribute повинно містити менше ніж :value елементів.',
    'file' => 'Розмір поля :attribute має бути меншим за :value кілобайт.',
    'numeric' => 'Поле :attribute має бути менше, ніж :value.',
    'string' => 'Поле :attribute має містити менше символів :value.',
    ],
    'lte' => [
    'array' => 'Поле :attribute не повинно містити більше ніж :value елементів.',
    'file' => 'Розмір поля :attribute має бути меншим або рівним :value кілобайтам.',
    'numeric' => 'Поле :attribute має бути менше або дорівнювати :value.',
    'string' => 'Поле :attribute має бути менше або дорівнювати символам :value.',
    ],
    'mac_address' => 'Поле :attribute має бути дійсною MAC-адресою.',
    'макс' => [
    'array' => 'Поле :attribute не повинно містити більше :max елементів.',
    'file' => 'Розмір поля :attribute не повинен перевищувати :max кілобайт.',
    'numeric' => 'Значення поля :attribute не повинно бути більшим за :max.',
    'string' => 'Поле :attribute не повинно перевищувати :max символів.',
    ],
    'max_digits' => 'Поле :attribute не повинно містити більше :max цифр.',
    'mimes' => 'Поле :attribute має бути файлом типу: :values.',
    'mimetypes' => 'Поле :attribute має бути файлом типу: :values.',
    'хв' => [
    'array' => 'Поле :attribute повинно містити щонайменше :min елементів.',
    'file' => 'Розмір поля :attribute має бути щонайменше :min кілобайт.',
    'numeric' => 'Поле :attribute має бути принаймні :min.',
    'string' => 'Поле :attribute має містити щонайменше :min символів.',
    ],
    'min_digits' => 'Поле :attribute повинно містити щонайменше :min цифр.',
    'missing' => 'Поле :attribute має бути відсутнє.',
    'missing_if' => 'Поле :attribute має бути відсутнє, якщо :other має значення :value.',
    'missing_unless' => 'Поле :attribute має бути відсутнє, якщо :other не дорівнює :value.',
    'missing_with' => 'Поле :attribute має бути відсутнє, якщо присутнє :values.',
    'missing_with_all' => 'Поле :attribute має бути відсутнє, якщо присутні :values.',
    'multiple_of' => 'Поле :attribute має бути кратним :value.',
    'not_in' => 'Вибраний :attribute недійсний.',
    'not_regex' => 'Формат поля :attribute недійсний.',
    'numeric' => 'Поле :attribute має бути числом.',
    'пароль' => [
    'letters' => 'Поле :attribute повинно містити принаймні одну літеру.',
    'mixed' => 'Поле :attribute повинно містити принаймні одну велику та одну малу літеру.',
    'numbers' => 'Поле :attribute повинно містити принаймні одне число.',
    'symbols' => 'Поле :attribute повинно містити принаймні один символ.',
    'uncompromised' => 'Вказаний :attribute з\'явився під час витоку даних. Будь ласка, виберіть інший :attribute.',
    ],
    'present' => 'Поле :attribute має бути присутнім.',
    'present_if' => 'Поле :attribute має бути присутнім, коли :other має значення :value.',
    'present_unless' => 'Поле :attribute має бути присутнім, якщо :other не дорівнює :value.',
    'present_with' => 'Поле :attribute має бути присутнім, коли присутнє :values.',
    'present_with_all' => 'Поле :attribute має бути присутнім, коли присутні :values.',
    'prohibited' => 'Поле :attribute заборонено.',
    'prohibited_if' => 'Поле :attribute заборонено, коли :other має значення :value.',
    'prohibited_if_accepted' => 'Поле :attribute заборонено, якщо прийнято поле :other.',
    'prohibited_if_declined' => 'Поле :attribute заборонено, коли :other відхилено.',
    'prohibited_unless' => 'Поле :attribute заборонено, якщо :other не вказано в :values.',
    'prohibits' => 'Поле :attribute забороняє присутність :other.',
    'regex' => 'Формат поля :attribute недійсний.',
    'required' => 'Поле :attribute обов\'язкове для заповнення.',
    'required_array_keys' => 'Поле :attribute має містити записи для: :values.',
    'required_if' => 'Поле :attribute є обов\'язковим, коли :other має значення :value.',
    'required_if_accepted' => 'Поле :attribute є обов\'язковим, якщо прийнято поле :other.',
    'required_if_declined' => 'Поле :attribute є обов\'язковим, коли :other відхилено.',
    'required_unless' => 'Поле :attribute є обов\'язковим, якщо :other не вказано в :values.',
    'required_with' => 'Поле :attribute є обов\'язковим, якщо присутній :values.',
    'required_with_all' => 'Поле :attribute є обов\'язковим, коли присутні :values.',
    'required_without' => 'Поле :attribute є обов\'язковим, якщо :values відсутнє.',
    'required_without_all' => 'Поле :attribute є обов\'язковим, коли жодне з :values не присутнє.',
    'same' => 'Поле :attribute має відповідати :other.',
    'розмір' => [
    'array' => 'Поле :attribute має містити елементи розміру :size.',
    'file' => 'Розмір поля :attribute має бути :size кілобайт.',
    'numeric' => 'Поле :attribute має бути :size.',
    'string' => 'Поле :attribute має містити символи розміру :size.',
    ],
    'starts_with' => 'Поле :attribute має починатися з одного з наступних значень: :values.',
    'string' => 'Поле :attribute має бути рядком.',
    'timezone' => 'Поле :attribute має бути дійсним часовим поясом.',
    'unique' => 'Атрибут :attribute вже зайнято.',
    'uploaded' => 'Не вдалося завантажити :attribute.',
    'uppercase' => 'Поле :attribute має бути написане великими літерами.',
    'url' => 'Поле :attribute має бути дійсною URL-адресою.',
    'ulid' => 'Поле :attribute має бути дійсним ULID.',
    'uuid' => 'Поле :attribute має бути дійсним UUID.',

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
        'partial_date' => [
            'format' => 'Поле :attribute має бути у форматі РРРР, РРРР-ММ або РРРР-ММ-ДД.',
            'year_range' => 'Рік :attribute має бути між :min та :max.',
            'invalid_month' => 'Місяць :attribute має бути між 01 та 12.',
            'day_without_month' => 'Не можна вказати день без місяця в :attribute.',
            'invalid_date' => 'Поле :attribute не є дійсною датою.',
            'after_birth' => 'Дата смерті має бути після дати народження.',
        ],
        'video_url' => ':attribute має бути дійсною URL-адресою відео YouTube. Приклади: https://youtu.be/xxxx або https://www.youtube.com/watch?v=xxxx',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
