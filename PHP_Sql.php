 <?php
    
  $conn = mysqli_connect("holland.mathcs.emory.edu","cs377", "abc123");

  $blanck = " ";
    
  if (mysqli_connect_errno())            # ------ check connection error       
  { 
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit(1);
  } 
    
  if ( mysqli_select_db($conn, "spjDB") == 0 )          # Select DB
  { 
     printf("Error: %s\n", mysqli_error($conn));
     exit(1);
  } 
    function get_query($s_name,$p_name,$j_name,$s_city,$p_city,$j_city){
        $query= "select s.sname Supplier_Name, s.city Supplier_City, p.pname Part_Name, p.city Part_City, j.jname Project_Name, j.city Project_City, spj.qty Quantity
                  from supplier s,part p, proj j, spj
                  where s.snum=spj.snum AND
                        p.pnum=spj.pnum AND
                        j.jnum=spj.jnum";
         if(strcmp($s_name, $blanck)){
            $query=$query. " AND s.sname like'$s_name'";
         }
         if(strcmp($p_name, $blanck)){
            $query=$query. " AND p.pname like'$p_name'";
         }
         if(strcmp($j_name, $blanck)){
            $query=$query. " AND j.jname like'$j_name'";
         }
         if(strcmp($s_city, $blanck)){
            $query=$query. " AND s.city like'$s_city'";
         }
         if(strcmp($p_city, $blanck)){
            $query=$query. " AND p.city like'$p_city'";
         }
         if(strcmp($j_city, $blanck)){
            $query=$query. " AND j.city like'$j_city'";
         }

        return ($query );
    }

    function wild($raw){
      for ( $i = 0; $i < strlen($raw); $i++ )                   
      {
        if ( $raw[$i] == '*' )
           $raw[$i] = '%';
        if ( $raw[$i] == '?' )
           $raw[$i] = '_';

      }
      return $raw;
     

    }
    
    $query=get_query(wild($_POST[sname]),wild($_POST[pname]),wild($_POST[jname]),wild($_POST[scity]),wild($_POST[pcity]),wild($_POST[jcity]);
      #printf($query);
      #print("<UL><TABLE bgcolor=\"#FFEEEE\" BORDER=\"5\">\n");
      #print("<TR> <TD><FONT color=\"blue\"><B><PRE>\n");
      #print($query);
      #print("</PRE></B></FONT></TD></TR></TABLE></UL>\n");
      #print("<P><HR><P>\n");
  if ( ( $result = mysqli_query($conn,$query )) == 0 )      # Execute query
  { 
     printf("Error: %s\n", mysqli_error($conn));
     exit(1);
  } 
    
     print("<UL>\n");
   print("<TABLE bgcolor=\"lightyellow\" BORDER=\"5\">\n");
        
   $printed = false;
   
   while ( $row = mysqli_fetch_assoc( $result ) )
   {      
      if ( ! $printed )
      {   
       $printed = true;                 # Print header once...
        
       print("<TR bgcolor=\"lightcyan\">\n");
       foreach ($row as $key => $value)
       {
          print ("<TH>" . $key . "</TH>");             # Print attr. name
       }
       print ("</TH>\n");
      }   
        
        
      print("<TR>\n");
      foreach ($row as $key => $value)
      {   
       print ("<TD>" . $value . "</TD>");
      }   
      print ("</TR>\n");
   }      
   print("</TABLE>\n");
   print("</UL>\n");
   print("<P>\n");
    
  mysqli_free_result($result);
    
  mysqli_close($conn);
  ?>