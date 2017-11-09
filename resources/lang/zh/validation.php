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

	"accepted"             => "该 :attribute 必须被接受。",
	"active_url"           => "该 :attribute 不是有效的链接。",
	"after"                => "该 :attribute 必须是在 :date 之后的日期。",
	"alpha"                => "该 :attribute 只能包含字母。",
	"alpha_dash"           => "该 :attribute 只能包含字母, 数字, 和下划线。",
	"alpha_num"            => "该 :attribute 只能包含字母 和数字。",
	"array"                => "该 :attribute 必须是个数组。",
	"before"               => "该 :attribute 必须是在 :date 之前的日期。",
	"between"              => array(
		"numeric" => "该 :attribute 必须在 :min 和 :max 之间。",
		"file"    => "该 :attribute 必须在 :min 和 :max KB之间。",
		"string"  => "该 :attribute 必须在 :min 和 :max 个之间。",
		"array"   => "该 :attribute 必须在 :min 和 :max 项之间。",
	),
	"confirmed"            => "该 :attribute 确认信息不匹配。",
	"date"                 => "该 :attribute 不是一个有效的日期。",
	"date_format"          => "该 :attribute 不匹配格式： :format。",
	"different"            => "该 :attribute 和 :other 必须不同。",
	"digits"               => "该 :attribute 必须是 :digits 个数。",
	"digits_between"       => "该 :attribute 必须在 :min 和 :max 个数之间。",
	"email"                => "该 :attribute 必须是有效的Email地址。",
	"exists"               => "该 selected :attribute 是无效的。",
	"image"                => "该 :attribute 必须是图像。",
	"in"                   => "选择的 :attribute 是无效的。",
	"integer"              => "该 :attribute 必须是个整数。",
	"ip"                   => "该 :attribute 必须是个有效的IP地址。",
	"max"                  => array(
		"numeric" => "该 :attribute 不能大于 :max。",
		"file"    => "该 :attribute 不能大于 :max KB",
		"string"  => "该 :attribute 不能大于 :max 个字符。",
		"array"   => "该 :attribute 不能多于 :max 项。",
	),
	"mimes"                => "该 :attribute 必须是文件类型： :values。",
	"min"                  => array(
		"numeric" => "该 :attribute 应大于 :min。",
		"file"    => "该 :attribute 应大于 :min KB。",
		"string"  => "该 :attribute 应大于 :min 个字符。",
		"array"   => "该 :attribute 至少应该有 :min 项。",
	),
	"not_in"               => "选择的 :attribute 是无效的。",
	"numeric"              => "该 :attribute 必须是个数字。",
	"regex"                => "该 :attribute 格式错误。",
	"required"             => "该 :attribute 项是必需的。",
	"required_if"          => "该 :attribute 项是必需的 当 :other 为 :value 时。",
	"required_with"        => "该 :attribute 项是必需的 当 :values 提供了。",
	"required_with_all"    => "该 :attribute 项是必需的 当 :values 提供了。",
	"required_without"     => "该 :attribute 项是必需的 当 :values 未提供。",
	"required_without_all" => "该 :attribute 项是必需的 当没有一个 :values 被提供时。",
	"same"                 => "该 :attribute 和 :other 必须匹配。",
	"size"                 => array(
		"numeric" => "该 :attribute 必须是 :size。",
		"file"    => "该 :attribute 必须是 :size KB。",
		"string"  => "该 :attribute 必须是 :size 个字符。",
		"array"   => "该 :attribute 必须包含 :size 项。",
	),
	"unique"               => " :attribute 已被使用。",
	"url"                  => "这个 :attribute 格式是无效的。",

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
			'rule-name' => '自定义消息',
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
