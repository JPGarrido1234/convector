    <title>Convector</title>
    <meta charset="utf-8">
    <meta name="author" content="<?php echo inkoa_sistemas ?>">
    <meta name="description" content="<?php echo descripcion ?>">
    <meta name="keywords" content="<?php echo convector_m ?>, <?php echo datalogger_m ?>, <?php echo inkoa_m ?>">
    <link href=<?php echo $_SERVER['DOCUMENT_ROOT']."/images/favicon.png" ?> rel="shortcut icon">
    <link href="../css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <script type="text/javascript" src="../javascript/javascript.js"></script>
    <script type="text/javascript" src="../javascript/jquery.js"></script>
    <script type="text/javascript" src="../javascript/maps.js"></script>
    <script type="text/javascript" src="../javascript/ajax.js"></script>
    <script type="text/javascript" src="../javascript/funcs_jquery.js"></script>
    <script type="text/javascript">
    //mcc 257,
    //mnc 216,
    //lac 22,
    //cid 24
        /*
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://us1.unwiredlabs.com/v2/process.php",
            "method": "POST",
            "headers": {},
            "processData": false,
            "data": "{\"token\": \"pk.29c13934e838783fb384b684eebdd7ec\",\"radio\": \"gsm\",\"mcc\": 257,\"mnc\": 216,\"cells\": [{\"lac\": 22,\"cid\":24}]}"
        }

        $.ajax(settings).done(function (response) {
            if(response){
                console.log(response);
            }
        });
        */
    </script>
<script type="text/javascript">
    const alarms_class = document.querySelectorAll(".ubi_alarm");
    if(alarms_class != null){
        alarms_class.forEach(function (element) {
            console.log('Ubicacion alarma : '+element.innerHTML);
        });
    }
</script>