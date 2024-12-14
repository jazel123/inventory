<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <style>
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-title {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 1.8em;
            font-weight: bold;
            color: #2c3e50;
        }

        .recent-activity {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .activity-title {
            font-size: 1.2em;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .activity-list {
            list-style: none;
            padding: 0;
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .welcome-message {
            margin-bottom: 30px;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="welcome-message">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
            <p>Here's your activity overview</p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-title">Today's Sales</div>
                <div class="stat-value">₱<?= number_format($todaySales, 2) ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Products Sold Today</div>
                <div class="stat-value"><?= $productsSoldToday ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Transactions Today</div>
                <div class="stat-value"><?= $transactionsToday ?></div>
            </div>
        </div>

        <div class="recent-activity">
            <h2 class="activity-title">Recent Activities</h2>
            <ul class="activity-list">
                <?php foreach ($recentActivities as $activity): ?>
                <li class="activity-item">
                    <?= htmlspecialchars($activity['description']) ?>
                    <div style="color: #666; font-size: 0.9em;">
                        <?= htmlspecialchars($activity['timestamp']) ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html> 