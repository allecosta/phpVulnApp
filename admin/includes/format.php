<?php

function numberFormatShort($number, $precision = 1 ) {
	if ($number < 900) {
		// 0 - 900
		$numberformat = number_format($number, $precision);
		$suffix = '';

	} else if ($number < 900000) {
		// 0.9k-850k
		$numberformat = number_format($number / 1000, $precision);
		$suffix = 'K';

	} else if ($number < 900000000) {
		// 0.9m-850m
		$numberformat = number_format($number / 1000000, $precision);
		$suffix = 'M';

	} else if ($number < 900000000000) {
		// 0.9b-850b
		$numberformat = number_format($number / 1000000000, $precision);
		$suffix = 'B';

	} else {
		// 0.9t+
		$numberformat = number_format($number / 1000000000000, $precision);
		$suffix = 'T';
	}

  // Remove zeros desnecessarios. "1.0" -> "1"; "1.00" -> "1"
  // Intencionalmente não afeta parciais. "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat('0', $precision );
		$numberformat = str_replace( $dotzero, '', $numberformat );
	}

	return $numberformat . $suffix;
}
