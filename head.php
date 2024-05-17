<?php
function head($title)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $root =  $_SERVER['HTTP_HOST'];

?>

    <head>
        <script>
            const root = "<?php echo $_SERVER['HTTP_HOST']; ?>";
            console.log(root);
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="">
        <link rel="shortcut icon" href="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/assets/images/favicon.svg" type="icon">
        <link rel="stylesheet" href="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/assets/css/styles.css">
        <link rel="stylesheet" href="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/dist/css/output.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <script type="module" src="http://<?php echo $root ?>/urbanpulse_ecommerce/node_modules/flowbite/dist/flowbite.js"></script>
        <!-- <script type="module" src="../assets/js/connectDatabase" defer></script> -->
        <!-- <script src="http://<?php echo $root ?>/urbanpulse_ecommerce/assets/js/pageLoad.js" defer></script> -->
        <script type="module" src="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/assets/js_beta/load.js"></script>
        <script type="module" src="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/assets/js/sessionRefresh.js" defer></script>
        <script type="module" src="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/assets/js/allProducts.js" defer></script>
        <script type="module" src="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/assets/js_beta/index.js" defer></script>
        <script type="module" src="http://<?php echo $root ?>/urbanpulse_ecommerce_beta/client/js/index.js" defer></script>
        <title><?php echo $title; ?></title>
    </head>
<?php } ?>