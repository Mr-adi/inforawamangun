<?php
require_once("../../../wp-blog-header.php");
add_action('wp_enqueue_scripts', 'pixflow_forbiddenStyle');
?>
<head>
    <?php
    wp_head();
    ?>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
</head>
<body>
    <div class="logo"><img src="assets/img/logo.jpg"></div>
    <div class="device-error">
        <div class="media">
            <div class="left">
                <div class="image"><img src="assets/img/error-device.png"></div>
            </div>
            <div class="right">
                <p class="title"><?php esc_attr_e('Error 999!','massive-dynamic'); ?></p>
                <p class="description"><?php esc_attr_e('Massive Builder is designed for desktop and laptop computers. It won\'t work on tablets or smart phones','massive-dynamic'); ?></p>
                <a class="dashboard" href="<?php echo esc_url($_GET['url']) ?>"><?php esc_attr_e('Take me Out Of Here','massive-dynamic'); ?></a>
            </div>
        </div>
    </div>
</body>
