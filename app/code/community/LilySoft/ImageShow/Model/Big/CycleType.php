<?php

class LilySoft_ImageShow_Model_Big_CycleType extends Varien_Object
{
    static public function toOptionArray()
    {
        return array(
            'blindX'		=>'blindX',
		    'blindY'		=>'blindY',
		    'blindZ'		=>'blindZ',
		    'cover'			=>'cover',
		    'curtainX'		=>'curtainX',
		    'curtainY'		=>'curtainY',
		    'fade'			=>'fade',
		    'fadeZoom'		=>'fadeZoom',
		    'growX'			=>'growX',
		    'growY'			=>'growY',
		    'scrollUp'		=>'scrollUp',
		    'scrollDown'	=>'scrollDown',
		    'scrollLeft'	=>'scrollLeft',
		    'scrollRight'	=>'scrollRight',
		    'scrollHorz'	=>'scrollHorz',
		    'scrollVert'	=>'scrollVert',
		    'shuffle'		=>'shuffle',
		    'slideX'		=>'slideX',
		    'slideY'		=>'slideY',
		    'toss'			=>'toss',
		    'turnUp'		=>'turnUp',
		    'turnDown'		=>'turnDown',
		    'turnLeft'		=>'turnLeft',
		    'turnRight'		=>'turnRight',
		    'uncover'		=>'uncover',
		    'wipe'			=>'wipe',
		    'zoom'			=>'zoom'
        );
    }
}