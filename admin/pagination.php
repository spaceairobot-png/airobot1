<?php


function pagination($query,$per_page,$page,$url,$conn){   


    //global $conDB; 
    //$query = "SELECT COUNT(*) as `num` FROM {$query}";
	
	$retval = mysqli_query($conn,$query);
         $row = mysqli_fetch_array($retval, MYSQLI_NUM );
         $total_records = $row[0];
         
		 //$total_pages = ceil($total_records / $per_page);  
    
		  $total = $total_records;  
	
    $adjacents = "2"; 
     
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
	$lastlabel = "Last &rsaquo;&rsaquo;";
     
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
     
    $prev = $page - 1;                          
    $next = $page + 1;
     
    $lastpage = ceil($total/$per_page);
     
    $lpm1 = $lastpage - 1; // //last page minus 1
     
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<div class='paginationNew'>";
        $pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
             
            if ($page > 1) $pagination.= "<li><a class='rpage' href='{$url}&pg={$prev}'>{$prevlabel}</a></li>";
             
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a  class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a class='rpage' href='{$url}&pg={$counter}'>{$counter}</a></li>";                    
            }
         
        } elseif($lastpage > 5 + ($adjacents * 2)){
             
            if($page < 1 + ($adjacents * 2)) {
                 
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a  class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a class='rpage' href='{$url}&pg={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li><a>...</a></li>";
                $pagination.= "<li><a class='rpage' href='{$url}&pg={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a class='rpage' href='{$url}&pg={$lastpage}'>{$lastpage}</a></li>";  
                     
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                 
                $pagination.= "<li><a class='rpage' href='{$url}&pg=1'>1</a></li>";
                $pagination.= "<li><a class='rpage' href='{$url}&pg=2'>2</a></li>";
                $pagination.= "<li><a>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a class='rpage' href='{$url}&pg={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li><a>..</a></li>";
                $pagination.= "<li><a class='rpage' href='{$url}&pg={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a class='rpage' href='{$url}&pg={$lastpage}'>{$lastpage}</a></li>";      
                 
            } else {
                 
                $pagination.= "<li><a class='rpage' href='{$url}&pg=1'>1</a></li>";
                $pagination.= "<li><a class='rpage' href='{$url}&pg=2'>2</a></li>";
                $pagination.= "<li><a>..</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a class='rpage' href='{$url}&pg={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
         
            if ($page < $counter - 1) {
				$pagination.= "<li><a class='rpage' href='{$url}&pg={$next}'>{$nextlabel}</a></li>";
				$pagination.= "<li><a class='rpage' href='{$url}&pg=$lastpage'>{$lastlabel}</a></li>";
			}
         
        $pagination.= "</div>";        
    }
     
    return $pagination;
}
?>