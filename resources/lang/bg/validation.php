<?php

return array(

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

	"accepted"             => ":attribute трябва да се приеме.",
	"active_url"           => ":attribute не е валиден URL.",
	"after"                => ":attribute трябва да е дата след :date.",
	"alpha"                => ":attribute може да съдържа само букви.",
	"alpha_dash"           => ":attribute може да съдържа само букви, цифри и тирета.",
	"alpha_num"            => ":attribute може да съдържа само букви и цифри.",
	"array"                => ":attribute трябва да е масив.",
	"before"               => ":attribute трябва да е дата преди :date.",
	"between"              => array(
		"numeric" => ":attribute трябва да е между :min и :max.",
		"file"    => ":attribute трябва да е между :min и :max килобайта.",
		"string"  => ":attribute трябва да е между :min и :max символа.",
		"array"   => ":attribute трябва да има между :min и :max елемента.",
	),
	"confirmed"            => ":attribute потвърждението не съвпада.",
	"date"                 => ":attribute не е валидна дата.",
	"date_format"          => ":attribute не съвпада с формат :format.",
	"different"            => ":attribute и :other трябва да се различават.",
	"digits"               => ":attribute трябва да е :digits .",
	"digits_between"       => ":attribute трябва да е между :min и :max .",
	"email"                => ":attribute трябва да е валиден email адрес.",
	"exists"               => "Избраният :attribute не е валиден.",
	"image"                => ":attribute трябва да е снимка.",
	"in"                   => "Избраният :attribute не е валиден.",
	"integer"              => ":attribute трябва да е число.",
	"ip"                   => ":attribute трябва да е валиден IP адресс.",
	"max"                  => array(
		"numeric" => ":attribute не може да бъде по-голям от :max.",
		"file"    => ":attribute не може да бъде по-голям от :max килобайта.",
		"string"  => ":attribute не може да бъде по-голям от :max символа.",
		"array"   => ":attribute не може да има повече от :max елемента.",
	),
	"mimes"                => ":attribute трябва да е файл с тип: :values.",
	"min"                  => array(
		"numeric" => ":attribute трябва да бъде най-малко :min.",
		"file"    => ":attribute трябва да бъде най-малко :min килобайта.",
		"string"  => ":attribute трябва да бъде най-малко :min символа.",
		"array"   => ":attribute трябва да бъде най-малко :min елемента.",
	),
	"not_in"               => "Избраният :attribute не е валиден.",
	"numeric"              => ":attribute трябва да е число.",
	"regex"                => ":attribute формат не е валиден.",
	"required"             => ":attribute поле е задължително.",
	"required_if"          => ":attribute поле е задължително когато :other е :value.",
	"required_with"        => ":attribute поле е задължително когато :values е избрано.",
	"required_with_all"    => ":attribute поле е задължително когато :values е избрано.",
	"required_without"     => ":attribute поле е задължително когато :values не е избрано.",
	"required_without_all" => ":attribute поле е задължително когато никое от :values не е избрано.",
	"same"                 => ":attribute и :other трябва да съвпадат.",
	"size"                 => array(
		"numeric" => ":attribute трабва да бъде :size.",
		"file"    => ":attribute трабва да бъде :size килобайта.",
		"string"  => ":attribute трабва да бъде :size символа.",
		"array"   => ":attribute трябва да съдържа :size елемента.",
	),
	"unique"               => ":attribute вече е заето.",
	"url"                  => ":attribute формат не е валиден.",

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

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

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

	'attributes' => array(),

);
