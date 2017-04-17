<?php 
class DateHelper {
	 /**
     * Author: Lien Son
     * @param type $string
     * @return Y-m-d H:i:s -> Today, Yesterday, 2 Days Ago,…after 6 days display the date in dd/mm/yyyy
     */
    public static function formatRecentReviewsDate($value) {
        if ($value == '0000-00-00 00:00:00' || is_null($value) || empty($value) || $value == '0000-00-00')
            return '';
        if (is_string($value)) {
            $now = time(); // or your date as well
            $review_date = strtotime($value);
            $datediff = $now - $review_date;
            $days = floor($datediff / (60 * 60 * 24));

            if ($days == 0) {
                $text_date = 'Today' . ", " . date("g:i A", strtotime($value));
            } else if ($days == 1) {
                $text_date = 'Yesterday' . ", " . date("g:i A", strtotime($value));
            } else if ($days > 1 && $days < 7) {
                $text_date = $days . " Days Ago" . ", " . date("g:i A", strtotime($value));
            } else if ($days == 7) {
                $text_date = '1 Week Ago' . ", " . date("g:i A", strtotime($value));
            } else {
                $text_date = date("d M y, g:i A", strtotime($value));
            }

            return $text_date;
        }
    }
}
?>