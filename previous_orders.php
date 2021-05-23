<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="previous_orders.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        
    </head>
    <body>

        <?php 
        session_start();
    
        $my_uid = $_SESSION['uid']   ;
        $my_username = $_SESSION['username']  ;
        $my_fullname = $_SESSION['fullname']  ;
        $my_email = $_SESSION['email']  ;
        $my_cart_id = $_SESSION['cart_id']  ;
        include "config.php";
        ?>

        <form action="market.php" method="">
          <input type="submit" value="GO BACK" style = 
            "width: fit-content;
            background-color: #4CAF50;
            color: white;
            margin: 8px 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;">
        </form>

        <table>
            <caption>PREVIOUS ORDERS</caption>
            <thead>
              <tr>
                <th scope="col">Order Id</th>
                <th scope="col">Order Date</th>
                <th scope="col">Items</th>
                <th scope="col">Total Price</th>
              </tr>
            </thead>
            <tbody>
              


          <?php
              $select_query = "SELECT * from orders,ordered WHERE orders.oid = ordered.oid AND ordered.uid = '$my_uid'";
              $result = mysqli_query($db,$select_query);
          
              while($row = mysqli_fetch_assoc($result)){
                  //echo $row["title"] . "<br>" . $row["description"] . "<br>" . $row["course_name"] . "<br>" . $row["price"]."<br>";
                
                $order_item_array = array(
                  'oid' => $row["oid"], 
                  'date' =>  $row["date"], 
                  'order_price' => $row["price"], 
                  'notes_in_this_order' => []
                );
              
                
                //echo $order_item_array["oid"] . "<br>".
                //$order_item_array["date"] . "<br>".
                //$order_item_array["order_price"] . "<br>".
                //"<br>";
                
                //PRINT OID
                echo
                '<tr>'.
                '<td data-label="Account">'.
                  $order_item_array["oid"].
                '</td>';

                //PRINT DATE
                echo
                '<td data-label="Due Date">'.
                  $order_item_array["date"].
                '</td>';

                //PRING ITEMS
                $select_notes_query = "SELECT * FROM note WHERE note_id IN (SELECT note_id FROM notesinorder WHERE oid = " . $order_item_array['oid'] . ")";
                $result_notes_query = mysqli_query($db,$select_notes_query);

                while($row_notes = mysqli_fetch_assoc($result_notes_query)){

                  $note_item_array = array(
                      'title' => $row_notes["title"], 
                      'description' =>  $row_notes["description"], 
                      'note_price' => $row_notes["price"],
                      'coursename' => $row_notes["course_name"]
                  );

                  //echo $note_item_array["title"] . "<br>".
                  //    $note_item_array["description"] . "<br>".
                  //    $note_item_array["note_price"] . "<br>".
                  //    $note_item_array["coursename"] . "<br>".
                  //    "<br>";
      
                  $order_item_array["notes_in_this_order"][] = $note_item_array;
                }
                echo
              '<td data-label="Amount">';

                foreach($order_item_array["notes_in_this_order"] as $key=>$value){
                  echo  
                  "<div class='w3-round-large w3-grey'>".
                    "<hr>".
                    "Item " . ($key+1). "<br><br>".
                    "<pr style='color:black; font-weight: bold;'> Title:       </pr>".  $value["title"] ."<br>".
                    "<pr style='color:black; font-weight: bold;'> Description: </pr>".  $value["description"] ."<br>".
                    "<pr style='color:black; font-weight: bold;'> Price:       </pr>" . $value["note_price"] . "$<br>".
                    "<pr style='color:black; font-weight: bold;'> Coursename:  </pr>" . $value["coursename"] . "<br>".
                    "<hr>".
                  "</div>".
                  "<br>" ; 
                }

              echo '</td>';
              

              //PRINT TOTAL PRICE
              echo
              '<td data-label="Period">'.
                $order_item_array["order_price"]. "$".
              '</td>'.
              '</tr>';
              }
              /*
              echo "<br> <br>FROM FOR LOOP <br>";
              foreach($order_item_array["notes_in_this_order"] as $value){
                echo  $value["title"] . "<br>" .
                      $value["description"] . "<br>" .
                      $value["note_price"] . "<br>" .
                      $value["coursename"] . "<br>" ; 
              }
              */


              //PRINT ITEM INFO
              
          ?>
                

                

                

                
             
             
            </tbody>
          </table>
    </body>


</html>


