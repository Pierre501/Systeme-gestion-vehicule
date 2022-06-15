<?php 
if ( ! defined('BASEPATH')) exit('No direct script accessallowed');

	if(!function_exists('img_loader'))
	{
		function img_loader($name, $format)
		{
			return site_url()."/assets/img/".$name.".".$format;
		}
	}

	if(!function_exists('css_loader'))
	{
		function css_loader($name)
		{
			return site_url()."/assets/css/".$name.".css";
		}
	}

	if(!function_exists('font_loader'))
	{
		function font_loader($name)
		{
			return site_url()."/assets/font/".$name.".php";
		}
	}

	if(!function_exists('js_loader'))
	{
		function js_loader($name)
		{
			return site_url()."/assets/js/".$name.".js";
		}
	}

	if(!function_exists('map_loader'))
    {
        function map_loader($name)
        {
            return site_url()."/assets/map/".$name.".map";
        }
    }
?>