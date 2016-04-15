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

	"accepted"             => ":attribute doit être accepté.",
	"active_url"           => ":attribute n'est pas une URL valide.",
	"after"                => ":attribute doit être une date postérieure à :date.",
	"alpha"                => ":attribute ne doit contenir que des lettres.",
	"alpha_dash"           => ":attribute ne doit contenir que des lettres, des chiffres ou des tirets.",
	"alpha_num"            => ":attribute ne doit contenir que des lettres ou des chiffres.",
	"array"                => ":attribute doit être un tableau.",
	"before"               => ":attribute doit être une date antérieure à :date.",
	"between"              => array(
		"numeric" => ":attribute doit être compris entre :min et :max.",
		"file"    => ":attribute doit avoir une taille comprise entre :min et :max kilooctets.",
		"string"  => ":attribute doit avoir une taille comprise entre :min et :max caractères.",
		"array"   => ":attribute doit contenir de :min à :max éléments.",
	),
	"confirmed"            => ":attribute n'est pas confirmé.",
	"date"                 => ":attribute n'est pas une date valide.",
	"date_format"          => ":attribute ne correspond pas au format :format.",
	"different"            => ":attribute et :other doivent être differents.",
	"digits"               => ":attribute doit avoir :digits chiffres.",
	"digits_between"       => ":attribute doit avoir entre :min et :max chiffres.",
	"email"                => ":attribute doit être une adresse email valide.",
	"exists"               => ":attribute n'existe pas.",
	"image"                => ":attribute doit être une image.",
	"in"                   => ":attribute est invalide.",
	"integer"              => ":attribute doit être un entier.",
	"ip"                   => ":attribute doit être une adresse IP valide.",
	"max"                  => array(
		"numeric" => ":attribute ne peut pas être supérieur à :max.",
		"file"    => ":attribute ne peut pas avoir une taille supérieure à :max kiloctets.",
		"string"  => ":attribute ne peut pas avoir une taille supérieure à :max caractères.",
		"array"   => ":attribute ne peut pas contenir plus de :max éléments.",
	),
	"mimes"                => ":attribute doit être un fichier du type : :values.",
	"min"                  => array(
		"numeric" => ":attribute ne peut pas être inférieur à :min.",
		"file"    => ":attribute ne peut pas avoir une taille inférieure à :min kiloctets.",
		"string"  => ":attribute ne peut pas avoir une taille inférieure à :min caractères.",
		"array"   => ":attribute ne peut pas contenir moins de :min éléments.",
	),
	"not_in"               => ":attribute est invalide.",
	"numeric"              => ":attribute doit être un nombre.",
	"regex"                => "Le format de :attribute est invalide.",
	"required"             => "Le champ :attribute est obligatoire.",
	"required_if"          => "Le champ :attribute est obligatoire si :other égale :value.",
	"required_with"        => "Le champ :attribute est obligatoire si :values est défini.",
	"required_with_all"    => "Le champ :attribute est obligatoire si :values est défini.",
	"required_without"     => "Le champ :attribute est obligatoire si :values n'est pas défini.",
	"required_without_all" => "Le champ :attribute est obligatoire si aucune des valeurs de :values n'est définie.",
	"same"                 => ":attribute et :other doivent correspondre.",
	"size"                 => array(
		"numeric" => ":attribute doit avoir une taille de :size.",
		"file"    => ":attribute doit avoir une taille de :size kiloctets.",
		"string"  => ":attribute doit avoir une taille de :size caractères.",
		"array"   => ":attribute doit contenir :size éléments.",
	),
	"unique"               => ":attribute doit être unique.",
	"url"                  => ":attribute n'est pas une URL valide.",

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
