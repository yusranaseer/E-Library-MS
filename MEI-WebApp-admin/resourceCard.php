<?php require 'FirestoreManager.php'; ?>
<div class="cards">
            <a href="resources.php" style="text-decoration: none;">
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                        $ref_table = 'practicle';
                        $firestoreManager = new FirestoreManager($firestore);
                        $totalPracCount = $firestoreManager->getTotalCount($ref_table);
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalPracCount; ?></div>
                        <div class="card-name" style="color: white;">Practicles</div>
                    </div>
                    <div class="icon-box">
                        <i class="fad fa-book" style="color: white;"></i>
                    </div>
                </div>
            </a>
            <a href="news.php" style="text-decoration: none;">
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                        $ref_table = 'newspaper';
                        $firestoreManager = new FirestoreManager($firestore);
                        $totalNewsCount = $firestoreManager->getTotalCount($ref_table);
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalNewsCount; ?></div>
                        <div class="card-name" style="color: white;">News Papers</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-user" style="color: white;"></i>
                    </div>
                </div>
            </a>
            <a href="past.php" style="text-decoration: none;">
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                        $ref_table = 'pastpaper';
                        $firestoreManager = new FirestoreManager($firestore);
                        $totalPastCount = $firestoreManager->getTotalCount($ref_table);
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalPastCount; ?></div>
                        <div class="card-name" style="color: white;">Past Papers</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-user-circle" style="color: white;"></i>
                    </div>
                </div>
            </a>
                <div class="card" style="background-color: black;">
                    <div class="card-content">
                        <?php
                            $totalResourceCount = $totalPracCount+$totalNewsCount+$totalPastCount;
                        ?>
                        <div class="number" style="font-size: 20px;"><?php echo $totalResourceCount; ?></div>
                        <div class="card-name" style="color: white;">Resources</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-user-circle" style="color: white;"></i>
                    </div>
                </div>
            </div>