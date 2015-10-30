<?php

class LilySoft_ImageShow_Model_Big_InsertType extends Varien_Object
{
    const STATUS_APPEND		= 'append';
    const STATUS_PREPEND	= 'prepend';
    const STATUS_BEFORE		= 'before';
    const STATUS_AFTER		= 'after';

    static public function toOptionArray()
    {
        return array(
            self::STATUS_APPEND		=> 'append',
            self::STATUS_PREPEND	=> 'prepend',
            self::STATUS_BEFORE		=> 'before',
            self::STATUS_AFTER   	=> 'after'
        );
    }
}