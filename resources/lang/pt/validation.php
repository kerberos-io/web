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

	"accepted"             => "O :attribute deve ser aceito.",
	"active_url"           => "O :attribute não é uma URL válida.",
	"after"                => "O :attribute deve ser uma data depois :date.",
	"alpha"                => "O :attribute só podem conter letras.",
	"alpha_dash"           => "O :attribute só podem conter letras, numeros e traços.",
	"alpha_num"            => "O :attribute só podem conter letras e numeros.",
	"array"                => "O :attribute deve ser uma matriz.",
	"before"               => "O :attribute deve ser uma data depois :date.",
	"between"              => array(
		"numeric" => "O :attribute deve situar-se entre :min e :max.",
		"file"    => "O :attribute deve situar-se entre :min e :max kilobytes.",
		"string"  => "O :attribute deve situar-se entre :min e :max caracteres.",
		"array"   => "O :attribute deve situar-se entre :min e :max items.",
	),
	"confirmed"            => "O :attribute confirmação não corresponde.",
	"date"                 => "O :attribute não é uma data válida.",
	"date_format"          => "O :attribute não coincide com o formato :format.",
	"different"            => "O :attribute e :other deve ser diferente.",
	"digits"               => "O :attribute devem ser de :digits digitos.",
	"digits_between"       => "O :attribute deve estar entre :min and :max digitos.",
	"email"                => "O :attribute Deve ser um endereço de e-mail válido.",
	"exists"               => "A seleção :attribute é inválida.",
	"image"                => "O :attribute deve ser uma imagem.",
	"in"                   => "A seleção :attribute é inválida.",
	"integer"              => "O :attribute deve ser inteiro.",
	"ip"                   => "O :attribute deve ser um endereço de IP válido.",
	"max"                  => array(
		"numeric" => "O :attribute não pode ser superior a :max.",
		"file"    => "O :attribute não pode ser superior a :max kilobytes.",
		"string"  => "O :attribute não pode ser superior a :max caracteres.",
		"array"   => "O :attribute não pode ter mais de :max items.",
	),
	"mimes"                => "O :attribute deve ser um arquivo do tipo: :values.",
	"min"                  => array(
		"numeric" => "O :attribute deve ser pelo menos :min.",
		"file"    => "O :attribute deve ser pelo menos :min kilobytes.",
		"string"  => "O :attribute deve ser pelo menos :min characters.",
		"array"   => "O :attribute deve ser pelo menos :min items.",
	),
	"not_in"               => "A seleção :attribute é inválida.",
	"numeric"              => "O :attribute deve ser um número.",
	"regex"                => "O :attribute tem formato inválido.",
	"required"             => "O :attribute campo é obrigatório.",
	"required_if"          => "O :attribute campo é obrigatório quando :other é :value.",
	"required_with"        => "O :attribute campo é obrigatório quando :values é presente.",
	"required_with_all"    => "O :attribute campo é obrigatório quando :values is presente.",
	"required_without"     => "O :attribute campo é obrigatório quando :values não é presente.",
	"required_without_all" => "O :attribute campo é obrigatório quando nenhum :values está presente.",
	"same"                 => "O :attribute e :other deve combinar.",
	"size"                 => array(
		"numeric" => "O :attribute deve ser :size.",
		"file"    => "O :attribute deve ser :size kilobytes.",
		"string"  => "O :attribute deve ser :size characters.",
		"array"   => "O :attribute deve ser :size items.",
	),
	"unique"               => "O :attribute deve ser.",
	"url"                  => "O :attribute formato é inválido.",

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
