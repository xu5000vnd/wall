<?php 
class BaseFormatter extends CFormatter {
	public function formatStatus($value) {
        return $value == STATUS_ACTIVE ? "Active": "Inactive";
    }

    public function formatYesNo($value) {
    	return $value == TYPE_YES ? 'Yes' : 'No';
    }
}
?>