<?php
$code = (isset($_GET['code']))?$_GET['code']:'';
if ($code!= '') {
    $token = $code;
}else{
    $token = esc_attr__('Something went wrong!','massive-dynamic');
}
?>
<style>
    .access-token{
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        display: inline-block;
        text-align: center;
    }
    .access-token .token{
        padding: 0 65px;
        background-color: #f2f2f2;
        font-size: 20px;
        line-height: 70px;
        color: #2aad32;
        border-radius: 5px;
    }
</style>
<div class="access-token">
    <img src="../../assets/img/instagram-token.png" alt="instagram token" />
    <h3 class="token"><?php echo esc_attr($token) ?></h3>
</div>
