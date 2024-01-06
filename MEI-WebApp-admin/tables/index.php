 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Pagination</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      <style>
	  body{background:yellow}
		table td{background:white!important}
		table th{background:black!important;color:white;text-align:center}
		
	  </style>
	  
	  </head>  
      <body>  
           <br /><br />  
           <div class="container">  
                <h3 align="center">Pagination </h3><br />  
                <div class="" id="pagination_data">  
                </div>  
           </div>  
      </body>  
	   <script>  
 $(document).ready(function(){  
      load_data();  
      function load_data(page)  
      {  
           $.ajax({  
                url:"pg2.php",  
                method:"POST",  
                data:{page:page},  
                success:function(data){  
                     $('#pagination_data').html(data);  
                }  
           })  
      }  
      $(document).on('click', '.pagination_value', function(){  
           var page = $(this).attr("id");  
           load_data(page);  
      });  
 });  
 </script>  

 </html>  
