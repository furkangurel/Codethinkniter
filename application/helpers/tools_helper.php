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

