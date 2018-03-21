<?php

function codethinkniter($value)
{
    echo base64_encode($value);
}

function validatemessage($value)
{
    $ci=get_instance();
    echo $ci->session->flashdata('a'.$value);
}

function message()
{
    $ci=get_instance();
    $name=config_item('thinksession');
    echo $ci->session->flashdata($name);
}

function auto_pilot($val)
{
	$ci=get_instance();
    return $ci->session->set_flashdata('auto_pilot',$val);
}
