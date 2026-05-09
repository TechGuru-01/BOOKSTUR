<div id="transactions-tab" class="tab-pane">
    <div class="content-card">
        <div class="card-header">
            <h2>Transaction History</h2>
            <p>Your recent purchases and order history.</p>
        </div>

        <?php if ($orders_result->num_rows > 0): ?>
            <div class="transaction-list">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $orders_result->fetch_assoc()): ?>
                            <tr>
                                <td><span class="order-id-text">#SSCR-<?= $order['order_id'] ?></span></td>
                                <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <span class="material-icons-outlined" style="font-size: 16px; color: #888;">payments</span>
                                        <?= $order['payment_method'] ?>
                                    </div>
                                </td>
                                <td><span style="color: #dc1717; font-weight: 700;">₱<?= number_format($order['total_amount'], 2) ?></span></td>
                                <td>
                                    <?php 
                                        $status = strtolower($order['status']);
                                        $statusColor = ($status == 'claimed') ? '#27ae60' : (($status == 'pending') ? '#f1c40f' : '#888');
                                        $statusBg = ($status == 'claimed') ? '#eafaf1' : (($status == 'pending') ? '#fef9e7' : '#f4f4f4');
                                    ?>
                                    <span class="status-badge status-<?= $status ?>" 
                                        style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: capitalize; color: <?= $statusColor ?>; background-color: <?= $statusBg ?>;">
                                        
                                        <span class="material-icons-outlined" style="font-size: 16px;">
                                            <?= ($status == 'claimed') ? 'check_circle' : 'hourglass_empty' ?>
                                        </span>
                                        <?= $order['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-view" title="View Details" onclick="viewOrderDetails(<?= $order['order_id'] ?>)">
                                        <span class="material-icons-outlined">visibility</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon-wrap">
                    <span class="material-icons-outlined">history_edu</span>
                </div>
                <p>No recent transactions found.</p>
                <a href="../dashboard/dashboard.php" class="btn-shop">Explore Bookstore</a>
            </div>
        <?php endif; ?>
    </div>
</div>