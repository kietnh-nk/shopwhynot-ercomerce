<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư Liên Hệ Từ Khách Hàng</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(20, 108, 67, 0.1);
            overflow: hidden;
            border: 1px solid rgba(20, 108, 67, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #14b6a0 0%, #0f5132 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: 40px 30px;
        }

        .field-group {
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f8fffe 0%, #f0f9f5 100%);
            border-radius: 12px;
            border-left: 4px solid #14b6a0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .field-group:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(20, 108, 67, 0.15);
        }

        .field-group::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #14b6a0, #22c55e, #14b6a0);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .field-label {
            font-weight: 600;
            color: #14b6a0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .field-label::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #14b6a0;
            border-radius: 50%;
            display: inline-block;
        }

        .field-value {
            color: #374151;
            font-size: 16px;
            word-break: break-word;
            background: white;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid rgba(20, 108, 67, 0.1);
        }

        .message-field {
            background: linear-gradient(135deg, #f0f9f5 0%, #e6f3ea 100%);
        }

        .message-value {
            min-height: 100px;
            white-space: pre-wrap;
            background: white;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid rgba(20, 108, 67, 0.1);
            box-shadow: inset 0 2px 4px rgba(20, 108, 67, 0.05);
        }

        .footer {
            background: #f8fafc;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .timestamp {
            background: linear-gradient(135deg, #14b6a0 0%, #22c55e 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .icon {
            width: 16px;
            height: 16px;
            fill: currentColor;
            display: inline-block;
            vertical-align: middle;
        }

        @media (max-width: 640px) {
            body {
                padding: 10px;
            }

            .email-container {
                border-radius: 12px;
            }

            .header,
            .content {
                padding: 20px;
            }

            .field-group {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>📧 Thư Liên Hệ Mới</h1>
            <p>Bạn có một tin nhắn mới từ khách hàng</p>
        </div>

        <div class="content">
            <div class="field-group">
                <div class="field-label">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    Họ và tên
                </div>
                <div class="field-value">{{ $data['name'] }}</div>
            </div>

            <div class="field-group">
                <div class="field-label">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path
                            d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                    </svg>
                    Địa chỉ email
                </div>
                <div class="field-value">{{ $data['email'] }}</div>
            </div>

            <div class="field-group message-field">
                <div class="field-label">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path
                            d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                    </svg>
                    Nội dung tin nhắn
                </div>
                <div class="field-value message-value">{{ $data['message'] }}</div>
            </div>
        </div>

        <div class="footer">
            <p>Email này được gửi tự động từ hệ thống liên hệ của website</p>
            <div class="timestamp">
                📅 Nhận lúc: {{ now()->format('H:i - d/m/Y') }}
            </div>
        </div>
    </div>
</body>

</html>
