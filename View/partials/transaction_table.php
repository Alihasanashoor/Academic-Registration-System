<?php
/**
 * Partial: Transaction Key/Value table
 * Expected: $tx (array) — keys from API
 * This is PRESENTATION ONLY. No logic, no API, no DB.
 */
?>
<table class="transaction-table">
    <thead>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr><th>Status</th><td><?= htmlspecialchars($transaction['status'] ?? 'N/A') ?></td></tr>
        <tr><th>Transaction Type</th><td><?= htmlspecialchars($transaction['type'] ?? 'N/A') ?></td></tr>
        <tr><th>Amount Taken</th><td><?= htmlspecialchars($transaction['Amount_taken'] ?? 'N/A') ?> BD</td></tr>
        <tr><th>Balance After</th><td><?= htmlspecialchars($transaction['Balance_After'] ?? 'N/A') ?> BD</td></tr>
        <tr><th>Product</th><td><?= htmlspecialchars($transaction['Product'] ?? 'N/A') ?></td></tr>
        <tr><th>Transaction ID</th><td><?= htmlspecialchars($transaction['Transaction_ID'] ?? 'N/A') ?></td></tr>
       
    </tbody>
</table>