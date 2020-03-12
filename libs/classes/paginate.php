<?php 
class Paginate{
	var $records_per_page;
	var $adjacents;
	var $totalRecords;
	var $pagination;
	var $start;
        public $is_search_enabled;
        public $input_field;
        var $searching_val = "";
	//default parametarized construtor for paginate class
	function __construct($totalRecords,$recPerPg,$adjcnt,$is_search_enabled=false,$input_field=""){
		$this->records_per_page=$recPerPg;
		$this->adjacents = $adjcnt;
		$this->totalRecords = $totalRecords;
		$this->start = 1;
		$this->pagination = "";
                $this->is_search_enabled = $is_search_enabled;
                $this->input_field = $input_field;
	}
	public function paginater($js_function_name='change_page'){
	//$totalRecords = $db->getValue("SELECT COUNT(sno) as total FROM institution ORDER BY sno");
        if($this->is_search_enabled){
            //$this->searching_val = ",$('#".$this->input_field."').val()";
            $this->searching_val = ',$("#'.$this->input_field.'").val()';
        }
        //echo("<textarea>".$this->searching_val."</textarea>");
	$page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
	$page = ($page == 0 ? 1 : $page);
	$this->start = ($page-1) * $this->records_per_page;

	$next = $page + 1;    
	$prev = $page - 1;
	$last_page = ceil($this->totalRecords/$this->records_per_page);
	$second_last = $last_page - 1; 

	//$pagination = "";
	if($last_page > 1){
		$this->pagination .= "<div class='pagination'>";
		if($page > 1)
			$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(1".$this->searching_val.");'>&laquo; First</a>";
		else
			$this->pagination.= "<span class='disabled'>&laquo; First</span>";

		if ($page > 1)
			$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($prev).$this->searching_val.");'>&laquo; Previous&nbsp;&nbsp;</a>";
		else
			$this->pagination.= "<span class='disabled'>&laquo; Previous&nbsp;&nbsp;</span>";   

		if ($last_page < 7 + ($this->adjacents * 2))
		{   
			for ($counter = 1; $counter <= $last_page; $counter++)
			{
				if ($counter == $page)
					$this->pagination.= "<span class='current'>$counter</span>";
				else
					$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($counter).$this->searching_val.");'>$counter</a>";     

			}
		}
		elseif($last_page > 5 + ($this->adjacents * 2))
		{
			if($page < 1 + ($this->adjacents * 2))
			{
				for($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)
				{
					if($counter == $page)
						$this->pagination.= "<span class='current'>$counter</span>";
					else
						$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($counter).$this->searching_val.");'>$counter</a>";     
				}
				$this->pagination.= "...";
				$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($second_last).$this->searching_val.");'> $second_last</a>";
				$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($last_page).$this->searching_val.");'>$last_page</a>";   

		   }
		   elseif($last_page - ($this->adjacents * 2) > $page && $page > ($this->adjacents * 2))
		   {
			   $this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(1".$this->searching_val.");'>1</a>";
			   $this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(2".$this->searching_val.");'>2</a>";
			   $this->pagination.= "...";
			   for($counter = $page - $this->adjacents; $counter <= $page + $this->adjacents; $counter++)
			   {
				   if($counter == $page)
					   $this->pagination.= "<span class='current'>$counter</span>";
				   else
					   $this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($counter).");'>$counter</a>";     
			   }
			   $this->pagination.= "..";
			   $this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($second_last).$this->searching_val.");'>$second_last</a>";
			   $this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($last_page).$this->searching_val.");'>$last_page</a>";   
		   }
		   else
		   {
			   $this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(1".$this->searching_val.");'>1</a>";
			   $this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(2".$this->searching_val.");'>2</a>";
			   $this->pagination.= "..";
			   for($counter = $last_page - (2 + ($this->adjacents * 2)); $counter <= $last_page; $counter++)
			   {
				   if($counter == $page)
						$this->pagination.= "<span class='current'>$counter</span>";
				   else
						$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($counter).$this->searching_val.");'>$counter</a>";     
			   }
		   }
		}
		if($page < $counter - 1)
			$this->pagination.= "<a href='javascript:void(0);' onClick='".$js_function_name."(".($next).$this->searching_val.");'>Next &raquo;</a>";
		else
			$this->pagination.= "<span class='disabled'>Next &raquo;</span>";

		if($page < $last_page)
			$this->pagination.= "<a href='javascript:void(0);' title='this is last' onClick='".$js_function_name."(".($last_page).$this->searching_val.");'>Last &raquo;</a>";
		else
			$this->pagination.= "<span class='disabled'>Last &raquo;</span>";

		$this->pagination.= "</div>";       
	  }
	}
}
?>