<?php require 'FirestoreManager.php'; ?>
<div class="cards">
            <a href="book.php" style="text-decoration: none;"> 
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                        $ref_table = 'book';
                        $firestoreManager = new FirestoreManager($firestore);
                        $totalBookCount = $firestoreManager->getTotalCount($ref_table);
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalBookCount; ?></div>
                        <div class="card-name" style="color: white;">Books</div>
                    </div>
                    <div class="icon-box">
                        <i class="fad fa-book" style="color: white;"></i>
                    </div>
                </div>
            </a>
            <a href="student.php" style="text-decoration: none;">
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                        $ref_table = 'student';
                        $firestoreManager = new FirestoreManager($firestore);
                        $totalStudentCount = $firestoreManager->getTotalCount($ref_table);
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalStudentCount; ?></div>
                        <div class="card-name" style="color: white;">Students</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-user" style="color: white;"></i>
                    </div>
                </div>
            </a>
            <a href="staff.php" style="text-decoration: none;">
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                        $ref_table = 'staff';
                        $firestoreManager = new FirestoreManager($firestore);
                        $totalStaffCount = $firestoreManager->getTotalCount($ref_table);
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalStaffCount; ?></div>
                        <div class="card-name" style="color: white;">Staffs</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-user-circle" style="color: white;"></i>
                    </div>
                </div>
            </a>
            <a href="innovations.php" style="text-decoration: none;">
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                        $ref_table = 'innovation';
                        $firestoreManager = new FirestoreManager($firestore);
                        $totalInnoCount = $firestoreManager->getTotalCount($ref_table);
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalInnoCount; ?></div>
                        <div class="card-name" style="color: white;">Innovations</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-hand-holding-usd" style="color: white;"></i>
                    </div>
                </div>
            </a>
            </div>