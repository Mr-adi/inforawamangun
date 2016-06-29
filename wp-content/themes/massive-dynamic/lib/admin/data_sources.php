<?php
// Portfolio
VP_Security::instance()->whitelist_function('template_is_standard');
function template_is_standard($value)
{
	if($value === 'standard')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('portfolio_attr_icon');
function portfolio_attr_icon($value)
{
	if($value === '1')
		return true;
	return false;
}