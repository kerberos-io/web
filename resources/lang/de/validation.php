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

	"accepted"             => ":attribute muss akzeptiert werden.",
	"active_url"           => ":attribute ist keine gültige URL.",
	"after"                => ":attribute Datum muss nach dem :date sein.",
	"alpha"                => ":attribute darf nur Buchstaben enthalten.",
	"alpha_dash"           => ":attribute darf nur Buchstaben, Nummern oder Striche enthalten.",
	"alpha_num"            => ":attribute darf nur Buchstaben oder Nummern enthalten.",
	"array"                => ":attribute muss eine Liste sein.",
	"before"               => ":attribute muss ein Datum vor dem :date sein.",
	"between"              => array(
		"numeric" => ":attribute muss zwischen :min und :max liegen.",
		"file"    => ":attribute muss zwischen :min und :max kilobytes sein.",
		"string"  => ":attribute muss zwischen :min und :max Zeichen lang sein.",
		"array"   => ":attribute muss zwischen :min und :max Elemente sein.",
	),
	"confirmed"            => "Das :attribute Bestätigung stimmt nicht überein.",
	"date"                 => "Tattribute ist kein gültiges Datum.",
	"date_format"          => "Tattribute Format stimmt nicht überein mit :format.",
	"different"            => "Tattribute und :other müssen sich unterscheiden.",
	"digits"               => "Tattribute muss aus Zahlen bestehen :digits.",
	"digits_between"       => ":attribute muss zwischen :min und :max Zahlen sein.",
	"email"                => "Tattribute muss eine gültige E-Mail Adresse sein.",
	"exists"               => "Das ausgewählte :attribute ist nicht gültig.",
	"image"                => ":attribute muss ein Bild sein.",
	"in"                   => "Das ausgewählte :attribute ist ungültig.",
	"integer"              => ":attribute muss eine Ganzzahl sein.",
	"ip"                   => ":attribute muss eine gültige IP Addresse sein.",
	"max"                  => array(
		"numeric" => ":attribute darf nicht größer als :max sein.",
		"file"    => ":attribute darf nicht größer als :max kilobytes sein.",
		"string"  => ":attribute darf nicht größer als :max Zeichen lang sein.",
		"array"   => ":attribute darf nicht mehr als :max Elemente haben.",
	),
	"mimes"                => ":attribute muss folgenden Dateityp haben: :values.",
	"min"                  => array(
		"numeric" => ":attribute Mindestwert ist :min.",
		"file"    => ":attribute Mindestwert ist :min kilobytes.",
		"string"  => ":attribute Mindestwert ist :min Zeichen.",
		"array"   => ":attribute muss mindestens :min Elemente haben.",
	),
	"not_in"               => "Ausgewählter Wert :attribute ist ungültig.",
	"numeric"              => ":attribute muss eine Zahl sein.",
	"regex"                => "Tattribute Format ist ungültig.",
	"required"             => "Tattribute Feld ist erforderlich.",
	"required_if"          => ":attribute Feld ist erforderlich wenn :other ist :value.",
	"required_with"        => ":attribute Feld ist erforderlich wenn :values ist vorhanden.",
	"required_with_all"    => ":attribute Feld ist erforderlich wenn :values ist vorhanden.",
	"required_without"     => ":attribute Feld ist erforderlich wenn :values ist nicht vorhanden.",
	"required_without_all" => ":attribute Feld ist erforderlich wenn keines der Werte :values vorhanden ist.",
	"same"                 => ":attribute und :other müssen übereinstimmen.",
	"size"                 => array(
		"numeric" => ":attribute erforderliche Größe ist :size.",
		"file"    => ":attribute erforderliche Größe ist :size kilobytes.",
		"string"  => ":attribute erforderliche Größe ist :size Zeichen.",
		"array"   => ":attribute muss :size Elemente enthalten.",
	),
	"unique"               => ":attribute ist schon vergeben.",
	"url"                  => ":attribute Format ist ungültig.",

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
