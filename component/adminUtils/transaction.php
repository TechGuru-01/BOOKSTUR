<?php
require_once '../../include/config.php';
require_once '../../include/auth_checker.php';

$stats_query = "SELECT 
    COUNT(*) as total_orders, 
    SUM(CASE WHEN status = 'Claimed' THEN total_amount ELSE 0 END) as total_revenue,
    SUM(CASE WHEN status = 'Claimed' THEN 1 ELSE 0 END) as completed_count,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_count
    FROM orders";
$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();

$orders_query = "SELECT o.*, u.full_name 
                 FROM orders o 
                 JOIN users u ON o.user_id = u.id 
                 ORDER BY o.created_at DESC";
$orders_result = $conn->query($orders_query);


 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Order Ledger | SSCR-C Bookstore</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../component/navbar/navbar.css">
    <link rel="stylesheet" href="../addItems/addItems.css">
    <link rel="stylesheet" href="adminUtils.css">
    <link rel="stylesheet" href="../../component/footer/footer.css">
    <link rel="stylesheet" href="transaction.css">
</head>
<body>

    <?php include '../../component/navbar/navbar.php'; ?>

    <header class="page-header tx-hero">
        <div class="tx-hero-content">
            <div class="text-container" style="margin-bottom: 0;">
                <h1>Order <span>Ledger</span> (Admin)</h1>
                <p>Monitor and manage all bookstore transactions.</p>
            </div>
        </div>
    </header>

    <!-- Stat Pills -->
    <div class="tx-hero-pills">
        <div class="tx-hero-pill tx-pill-orders">
            <div class="tx-pill-icon"><span class="material-icons-outlined">receipt</span></div>
            <div>
                <div class="tx-pill-label">Total Orders</div>
                <div class="tx-pill-value"><?= number_format($stats['total_orders']) ?></div>
            </div>
        </div>
        <div class="tx-hero-pill tx-pill-revenue">
            <div class="tx-pill-icon"><span class="material-icons-outlined">payments</span></div>
            <div>
                <div class="tx-pill-label">Total Revenue</div>
                <div class="tx-pill-value">₱<?= number_format($stats['total_revenue'] ?? 0, 2) ?></div>
            </div>
        </div>
        <div class="tx-hero-pill tx-pill-completed">
            <div class="tx-pill-icon"><span class="material-icons-outlined">check_circle</span></div>
            <div>
                <div class="tx-pill-label">Claimed</div>
                <div class="tx-pill-value"><?= number_format($stats['completed_count']) ?></div>
            </div>
        </div>
        <div class="tx-hero-pill tx-pill-pending">
            <div class="tx-pill-icon"><span class="material-icons-outlined">pending</span></div>
            <div>
                <div class="tx-pill-label">Pending</div>
                <div class="tx-pill-value"><?= number_format($stats['pending_count']) ?></div>
            </div>
        </div>
    </div>

    <main class="tx-main">
        <div class="tx-section-header">
            <div class="tx-section-title-group">
                <h2 class="tx-section-title">All Transactions</h2>
                <p class="tx-section-sub">Real-time list of customer purchases.</p>
            </div>
            
                <div class="tx-search-wrap">
                    <span class="material-icons-outlined tx-search-icon">search</span>
                    <input type="text" id="txSearch" onkeyup="filterOrders()" placeholder="Search Customer or ID..." class="tx-filter-input">
                </div>
            </div>
        </div>

        <div class="tx-table-wrap">
            <table class="tx-table" id="mainTable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th class="hide-sm">Method</th>
                        <th>Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-right hide-sm">Date</th>
                        <th class="text-center">Details</th>
                    </tr>
                </thead>
                        <tbody id="historyTable">
    <?php if ($orders_result->num_rows > 0): ?>
        <?php while ($row = $orders_result->fetch_assoc()): 
            $bgColor = '';
            if ($row['status'] == 'Pending') {
                $bgColor = 'background-color: #fffa6a54;'; 
            } elseif ($row['status'] == 'Claimed') {
                $bgColor = 'background-color: #d1e7dd;'; 
            }
        ?>
            <tr style="<?= $bgColor ?>" 
                data-order="#SSCR-<?= $row['order_id'] ?>"
                data-customer="<?= htmlspecialchars($row['full_name']) ?>"
                data-status="<?= $row['status'] ?>"
                data-date="<?= date('M d, Y', strtotime($row['created_at'])) ?>">
                
                <td><span class="tx-order-id">#SSCR-<?= $row['order_id'] ?></span></td>
                <td><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                <td class="tx-muted tx-italic hide-sm"><?= $row['payment_method'] ?></td>
                <td class="tx-bold tx-dark">₱<?= number_format($row['total_amount'], 2) ?></td>
                <td class="text-center">
                    <select class="tx-badge tx-badge-<?= strtolower($row['status']) ?> border-0" 
                            style="cursor: pointer; outline: none;"
                            onchange="updateStatus(this, <?= $row['order_id'] ?>)">
                        <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Claimed" <?= $row['status'] == 'Claimed' ? 'selected' : '' ?>>Claimed</option>
                    </select>
                </td>
                <td class="tx-order-date text-right tx-muted hide-sm">
                    <?= date('M d, Y', strtotime($row['created_at'])) ?>
                </td>
                <td class="text-center">
                    <button class="tx-btn-view" onclick="viewOrderDetails(<?= $row['order_id'] ?>)">
                        <span class="material-icons-outlined">visibility</span>
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="7" class="text-center">No records found.</td></tr>
    <?php endif; ?>
</tbody>
            </table>
        </div>
    </main>
    <?php include '../../component/footer/footer.php'?>
    <?php include 'adminUtils.php'?>
    <?php include '../addItems/addItems.php'?>
    
    <script src="../../icons/sweetalert2.all.min.js"></script>
     <script src="../addItems/addItems.js"></script>
     <script src="adminUtils.js"></script>
    <script src="filterFunction.js"></script>
</body>
</html>