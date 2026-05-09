<?php
$raw_pos = $_SESSION['course'] ?? 'NOT_SET';
echo "";

$current_position = strtoupper(trim($raw_pos)); 
$isAdmin = ($current_position === 'ADMIN' || $current_position === 'SUPER ADMIN');
?>
<?php if ($isAdmin):?>
<div class="ubuntu-fab-container">
    <div class="ubuntu-menu" id="ubuntuMenu">
        
        <button class="ubuntu-item" onclick="openAppendModal()">
            <span class="material-symbols-outlined">auto_stories</span>
            Add Items
        </button>
        <a href="../../component/adminUtils/transaction.php">
         <button class="ubuntu-item">
            <span class="material-symbols-outlined">history</span>
             History
        </button>
        </a>
        
    </div>

    <button class="ubuntu-launcher" id="launcherBtn">
        <span class="material-symbols-rounded">grid_view</span>
    </button>
</div>
<?php endif?>