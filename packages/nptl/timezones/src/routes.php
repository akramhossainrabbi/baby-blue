<?php

Route::group( [ "namespace" => "NPTL\Timezones" ], function () {
	Route::get( "timezones/{timezone?}", "TimezonesController@index" );
} );