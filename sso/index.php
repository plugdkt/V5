<?php
// client_sample/index.php
// ponytail: mock client application homepage verifying SSO login integration.

session_start();
require_once 'config.php';

$is_logged_in = isset($_SESSION['client_logged_in']) && $_SESSION['client_logged_in'] === true;
$user = $_SESSION['client_user'] ?? null;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจองรถตู้ออนไลน์ (ระบบจำลองเชื่อมต่อ SSO)</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Sarabun:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Sarabun', 'Outfit', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 { font-size: 1.5rem; margin-bottom: 10px; color: #0284c7; }
        p { color: #64748b; margin-bottom: 30px; font-size: 0.95rem; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background-color: #0284c7;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn:hover { background-color: #0369a1; }
        .profile-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.9rem;
        }
        .info-row:last-child { border-bottom: none; }
        .label { color: #64748b; font-weight: 500; }
        .val { font-weight: 600; color: #0f172a; }
    </style>
</head>
<body>

    <div class="container">
        <i class="fa-solid fa-van-shuttle" style="font-size: 3rem; color: #0284c7; margin-bottom: 20px;"></i>
        <h1>ระบบจองรถตู้ออนไลน์ คณะวิทยาศาสตร์การแพทย์</h1>
        <p>ตัวอย่างการจำลองระบบย่อยที่เชื่อมเข้ากับระบบบัญชีกลาง</p>

        <?php if (!$is_logged_in): ?>
            <div style="background-color: #f0f9ff; border: 1px solid #bae6fd; padding: 15px; border-radius: 8px; margin-bottom: 30px; font-size: 0.9rem; color: #0369a1;">
                <i class="fa-solid fa-lock"></i> หน้าจอนี้ต้องการการเข้าสู่ระบบ
            </div>
            
            <a href="login.php" class="btn">
                <i class="fa-solid fa-shield-halved"></i>
                <span>เข้าสู่ระบบผ่าน MEDSCI ACC (SSO)</span>
            </a>
        <?php else: ?>
            <div class="profile-card">
                <h3 style="margin-bottom: 15px; color: #0f172a;"><i class="fa-solid fa-user-check"></i> เข้าสู่ระบบสำเร็จแล้ว</h3>
                
                <div class="info-row">
                    <span class="label">ชื่อผู้ใช้งาน</span>
                    <span class="val"><?php echo htmlspecialchars($user['username']); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">ชื่อ-นามสกุล</span>
                    <span class="val"><?php echo htmlspecialchars($user['name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">ตำแหน่ง</span>
                    <span class="val"><?php echo htmlspecialchars($user['pos_name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">ฝ่ายงาน / สังกัด</span>
                    <span class="val"><?php echo htmlspecialchars($user['div_name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">อีเมล</span>
                    <span class="val"><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
            </div>

            <a href="login.php?action=logout" class="btn" style="background-color: #64748b;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>ออกจากระบบ</span>
            </a>
        <?php endif; ?>
    </div>

</body>
</html>
