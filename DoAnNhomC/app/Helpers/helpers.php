<?php

use App\Models\Page;


function staticPage()
    {
        $page = Page::orderBy('name','ASC')->get();
        return $page;
    }