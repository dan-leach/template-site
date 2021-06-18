<?php
    $siteTitle = "Template Site";
    $siteVersion = 1.0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $siteTitle; ?></title>

    <!--load header dependencies such as bootstrap etc from separate file-->
    <?php include "include/dependencies.php";?>

</head>
<body>
    <div id="app">
        <!--navbar-->
        <nav class="navbar navbar-expand-sm bg-info navbar-light">
            <a class="navbar-brand" href="/"><img src="include/img/logo.png" alt="<?php echo $siteTitle; ?> Logo" height="50">&nbsp;<?php echo $siteTitle; ?></a>
        </nav>

        <!--div for placing banner alerts-->
        <div id="alert"></div>

        <!--main content div-->
        <div class="container">
            <!--loading message with spinner, hidden on mounted event-->`
            <section v-if="show.loader" id="loader">
                <br><br>
                <div class="spinner-border"></div>    
                Please wait... <?php echo $siteTitle; ?> loading
            </section>

            <!--starting view, shown on mounted event-->
            <section v-if="show.start" id="start" v-cloak>
                Starting view
            </section>

            <!--prevent content being hidden by footer-->
            <div id="spacer"></div>
        </div>

        <!--site footer-->
        <?php include "include/footer.php";?>
    </div>

    <!--vue-->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <!--main JS file-->
    <script src="include/app.js"></script>
</body>
</html>