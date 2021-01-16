<?php
/**
 * Choice class
 * Author: Fernando Martinez
 */
class Choice {
	private $display,$navto,$mark;

	function getDisplay() {
		return $this->display;
	}

	function setDisplay($display) {
		$this->display = $display;
	}

	function getNavto() {
		return $this->navto;
	}

	function setNavto($navto) {
		$this->navto = $navto;
	}

	function getMark() {
		return $this->mark;
	}

	function setMark($mark) {
		$this->mark = $mark;
	}

}
?>
