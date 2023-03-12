<?php

namespace App\SM;

use Barryvdh\Debugbar\Facade as Debugbar;

trait SM_Common {


	final static function smGetSystemFrontEndCss( $cssArray, $isFullLink = 0, $relation = "stylesheet" ) {
		$cssStr = "";
		if ( is_array( $cssArray ) && count( $cssArray ) > 0 ) {
			foreach ( $cssArray as $css ) {
				$cssStr .= '<link href="';
				$cssStr .= ( $isFullLink == 0 ) ? asset( "css/" . $css . ".css" ) : $css;
				$cssStr .= '" rel="' . $relation . '" type="text/css">' . "\n";
			}
		}
		echo $cssStr;
	}

	final static function smGetSystemFrontEndJs( $jsArray, $isFullLink = 0 ) {
		$jsStr = "";
		if ( is_array( $jsArray ) && count( $jsArray ) > 0 ) {
			foreach ( $jsArray as $js ) {
				$jsStr .= '<script src="';
				$jsStr .= ( $isFullLink == 0 ) ? asset( "js/" . $js . ".js" ) : $js;
				$jsStr .= '"></script>' . "\n";
			}
		}
		echo $jsStr;
	}

	final static function smGetSystemBackEndImgUri( $extra = null ) {

		return "/nptl-admin/img" . $extra;
	}

}
