<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ mix('/js/nn.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .liked {
            color: pink;
        }

        /* 文字折り返し設定 */
        body {
            word-wrap: break-word;
        }

        /* ヘッダー */
        .header {
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(175, 176, 195);
            margin-bottom: 8px;
        }

        .header h2 {
            font-size: 35px;
            font-weight: bold;
        }

        /* 中央寄せ */
        .center {
            max-width: 950px;
            margin: 0 auto;
            padding-left: 18px;
            padding-right: 18px;
        }

        h2 {
            font-size: 16px;
        }


        .form {
            text-align: center;
            background-color: rgb(226, 231, 240);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 6px;

        }

        .topic {
            background-color: rgb(226, 231, 240);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 6px;
        }

        .topic p {
            margin: 0;
        }

        hr {
            margin: 0;
        }

        #ftop {
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    <div class="header">
        <a style="text-decoration: none" href="{{ route('topics.index') }}">
            <h2 style="color: black">みんなの掲示板</h2>
        </a>
    </div>
    <div class="content">
        @yield('content')
    </div>
    <div class="footer">
        @yield('footer')
    </div>
</body>

</html>
