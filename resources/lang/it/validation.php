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

	"accepted"             => ":attribute deve essere accettato.",
	"active_url"           => ":attribute non è una URL valida.",
	"after"                => ":attribute deve essere una data dopo :date.",
	"alpha"                => ":attribute può contenere solo lettere.",
	"alpha_dash"           => ":attribute può contenere solo lettere, numeri e trattini.",
	"alpha_num"            => ":attribute può contenere solo lettere e numeri.",
	"array"                => ":attribute deve essere un array.",
	"before"               => ":attribute deve essere una data prima di :date.",
	"between"              => array(
		"numeric" => ":attribute deve essere compreso tra :min e :max.",
		"file"    => ":attribute deve essere compreso tra :min e :max kilobytes.",
		"string"  => ":attribute deve essere compreso tra :min e :max caratteri.",
		"array"   => ":attribute deve avere tra :min e :max elemnti.",
	),
	"confirmed"            => "La confemra di :attribute non corrisponde.",
	"date"                 => ":attribute non è una data valida.",
	"date_format"          => ":attribute non corrisponde al formato :format.",
	"different"            => ":attribute e :other devono essere diversi.",
	"digits"               => ":attribute deve essere di :digits cifre.",
	"digits_between"       => ":attribute deve essere compreso tra :min and :max digits.",
	"email"                => ":attribute deve essere un indirizzo email valido.",
	"exists"               => "Il/La :attribute selezionato/a è invalido/a.",
	"image"                => ":attribute deve essere un\'immagine.",
	"in"                   => "Il/La :attribute selezionato/a è invalido/a.",
	"integer"              => ":attribute deve essere un numero intero.",
	"ip"                   => ":attribute deve essere un indirizzo IP valido.",
	"max"                  => array(
		"numeric" => ":attribute non può essere più grande di :max.",
		"file"    => ":attribute non può essere più grande di :max kilobytes.",
		"string"  => ":attribute non può essere più grande di :max caratteri.",
		"array"   => ":attribute non può avare più di :max elementi.",
	),
	"mimes"                => ":attribute deve essere un file del tipo: :values.",
	"min"                  => array(
		"numeric" => ":attribute deve essere almeno :min.",
		"file"    => ":attribute deve essere almeno :min kilobytes.",
		"string"  => ":attribute deve essere almeno :min caratteri.",
		"array"   => ":attribute deve avere almeno :min elementi.",
	),
	"not_in"               => "Il/La :attribute selezionato/a è invalido/a.",
	"numeric"              => ":attribute deve essere un numero.",
	"regex"                => "Il formato di :attribute è invalido.",
	"required"             => "La voce :attribute è obbligatoria.",
	"required_if"          => "La voce :attribute è obbligatoria quando :other è :value.",
	"required_with"        => "La voce:attribute è obbligatoria quando :values è presente.",
	"required_with_all"    => "La voce :attribute è obbligatoria quando :values è presente.",
	"required_without"     => "La voce :attribute è obbligatoria quando :values non è presente.",
	"required_without_all" => "La voce :attribute è obbligatoria quando nessuno di :values è presente.",
	"same"                 => "La voce :attribute e :other devono corrispondere.",
	"size"                 => array(
		"numeric" => ":attribute deve essere :size.",
		"file"    => ":attribute deve essere :size kilobytes.",
		"string"  => ":attribute deve essere :size caratteri.",
		"array"   => ":attribute deve contenere :size elementi.",
	),
	"unique"               => ":attribute è gia stato/a scelto/a.",
	"url"                  => "Il formato di :attribute è invalido.",

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
