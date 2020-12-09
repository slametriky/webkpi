<?php

    function tgl_indo($tgl){

        $pecah = explode("-",$tgl);

        return $pecah[2].'-'.$pecah[1].'-'.$pecah[0];

    }