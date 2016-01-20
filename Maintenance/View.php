<head>
    <meta charset="utf-8"/>
    <title><?php echo $msg ?></title>
    <style type="text/css">
    body
    {
        background: #e9e9e9;
        background: <?php echo $bg_color ?>;
        margin: 0px;
        padding: 0px;
    }

    div 
    {
        box-shadow: 0px 3px 6px 3px rgba(0,0,0,0.2);
        border:1px solid gray;
        border-radius:5px;
        display: inline-block;
        padding:30px;
        font-size: 16px;
        font: 20px Georgia, "Times New Roman", Times, serif;
        width: 460px;
        margin: 60px auto;
        display: block;
        background: white;
        text-align: center;
    }
    </style>

</head>
<body>
    <div><?php echo $msg ?></div>
</body>