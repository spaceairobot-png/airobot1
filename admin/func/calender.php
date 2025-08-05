<?php
// Start output buffering at the very beginning to capture any output

error_reporting(E_ALL);
ini_set('display_errors', 1);


?>


  <link rel="stylesheet" href="../css/calender.css">
  
  <script src="../js/jquery-1.12.4.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/jquery.tablesorter.min.js"></script>
  <script>
    // Use noConflict if needed (remove if not required)
    $.noConflict();
    jQuery(document).ready(function($) {
      
      // Initialize datepicker
      $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '1950:2050'
      });

      // Set current time for inputs with value="now"
      $('input[type="time"][value="now"]').each(function(){    
        var d = new Date(),        
            h = d.getHours(),
            m = d.getMinutes();
        if(h < 10) h = '0' + h; 
        if(m < 10) m = '0' + m; 
        $(this).attr({
          'value': h + ':' + m
        });
      });
      
      // Initialize tablesorter for multiple tables in one call
      $("#sortedtable, #sortedtable2, #sortedtable3, #sortedtable4, #sortedtable5, #sortedtable6, #sortedtable7, #sortedtable8").tablesorter({
        sortList: [[0,0]]
      });
      
    });
  </script>

