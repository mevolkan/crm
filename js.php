<?php
include 'creds.php';
?>
<script type="text/javascript">
    var userId = <?php echo json_encode($credsData['UserId']); ?>;
    var secret = <?php echo json_encode($credsData['Secret']); ?>;


    var loginUrl = "https://jumla.cic.co.ke/api/Auth/Login";
    let data = {
        userID: userId,
        secret: secret
    };

    fetch(loginUrl, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': '*'
        },
        mode: 'cors',
        body: JSON.stringify(data)
    }).then(res => {
        console.log("Request complete! response:", res);
    }).then(data => {
        console.log(data)
    });
</script>