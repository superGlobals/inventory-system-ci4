<?php
/**
 * Displaying errors in from
 */
function show_error($validation, $fields)
{
    if($validation->hasError($fields))
    {
        return $validation->getError($fields);
    }
}

function get_date($date)
{
	return date("jS M, Y",strtotime($date));
}