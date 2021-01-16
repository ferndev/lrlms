<?php
/**
 * Assignment class
 * Author: Fernando Martinez
 */
class Assignment {
	private $name,$delivery,$bydate;
	private $files = array();

	function getName() {
		return $this->name;
	}

	function setName($name) {
		$this->name = $name;
	}

	function getDelivery() {
		return $this->delivery;
	}

	function setDelivery($delivery) {
		$this->delivery = $delivery;
	}

	function getBydate() {
		return $this->bydate;
	}

	function setBydate($bydate) {
		$this->bydate = $bydate;
	}

	function getFile($index) {
		return $this->files[$index];
	}

	function addFile($file) {
		$this->files[] = $file;
	}

	function getFileCount(){
		return count($this->files);
	}

        function toXML(){
            if($this->name==null || strlen($this->name)==0){
                return '';
            }
            $xml='        <assignment name="'.$this->name.'" delivery="'.$this->delivery.'" bydate="'.$this->bydate.'">'."\n";
            foreach($this->files as $file){
                $xml.='            <file name="'.$file->getName().'" />'."\n";
            }
            $xml.='        </assignment>'."\n";
            return $xml;
        }
}
?>
