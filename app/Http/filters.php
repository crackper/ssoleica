<?php

Route::filter('trabajador/create', function()
{
    // check the current user
    if (!Entrust::can('create-trabajador')) {
        return Redirect::to('trabajador');
    }
});

