<?php require_once('conn.php'); 
                        if ($conn->connect_error) {
                            die('Connection failed: ' . $conn->connect_error);
                        }
                        $sql = "SELECT nazov,cena FROM produkty WHERE id_skupina = ?";
                        $stmt = mysqli_prepare($conn,$sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $i = 0;
                        global $classContent,$moneyCount,$money;
                        $moneyCount = 0;
                        $money = array();
                        $classContent = array();
                        while($row = mysqli_fetch_assoc($result)){
                            $var = utf8_encode($row['nazov']);
                            $mon = $row['cena'];
                            $classContent[$i] = $var;
                            $money[$i] = $mon;
                            $i++;
                        }
                        ?>
                        <?php foreach($classContent as $content ):?>
                            <div style="background-color:white;width:70%;display:flex;height:100px;border:3px solid black;align-items:center;margin-bottom:20px;">
                            <div style="font-size:20px;width:65%;background-color:white;
                            height:80px;display:flex;align-items:center;">&nbsp&nbsp<?php echo $content;?>
                            </div>
                            <div style="font-size:20px;width:20%;background-color:white;
                            height:80px;display:flex;align-items:center;">cena: <?php echo $money[$moneyCount]; $moneyCount++;?>
                            </div>
                            <input type="submit" value="Buy" class="buyButton"></input>
                            </div>
                        <?php endforeach;?>