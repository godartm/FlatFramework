<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .header {
            height: 50px;
            line-height: 50px;
            color: aliceblue;
            font-family: sans-serif;
            font-weight: bold;
            width: 100%;
            background: #333;
            text-align: center;
        }

        r {
            color: red;
        }

        pre {
            display: inline-block;
            padding: 0;
            color: #333;
            margin: 0;
            line-break: loose;
            border-radius: 4px;
            margin-top: 25px;
            width: 100%;
            word-wrap: break-word;
            white-space: -moz-pre-wrap;
            white-space: pre-wrap;
        }

        .content {
            line-height: 5px;
            margin: 50px auto auto;
            background: #e0e0e0;
            width: 80%;
            border: 1px solid #c5c5c5;
            border-radius: 5px;
            padding: 15px;
        }

        .id {
            display: inline-block;
            padding: 0;

            background: #ffffff;
            border: 1px solid #c5c5c5;
            width: 5%;
            height: 50px;
            line-height: 50px;
            text-align: center;
            float: left;
            border-radius: 5px;
            margin-top: 10px;

        }

        .code {
            display: inline-block;
            margin: 0;
            background: #ffffff;
            border: 1px solid #c5c5c5;
            width: 91%;
            height: auto;
            line-height: 25px;
            border-radius: 5px;
            float: left;
            font-size: 16px;
            padding: 1%;

        }

        .line {
            font-size: 12px;
            color: #6c6c6c;
        }
    </style>
</head>
<body>
<div class="header">
    Flat Framework -
    <r>Error</r>
    StackTrace
</div>

<div class="content">

    @foreach($trace as $t)

        <pre>


        <div class="id">{{ str_replace(' ','', $t['id']) }}</div>
        <div class="code">

           {{ $t['code'] }}
            <div class="line">
           {{ $t['line'] }}
        </div>
        </div>

</pre>


    @endforeach

</div>
</body>
</html>

