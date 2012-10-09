<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));



$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-pre-only';
    }else{
        $bodyclasses[] = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    }else{
        $bodyclasses[] = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<img id="logo" src="" alt="Home" />
<div id="wrapper">
<div id="header">

	<div class="login"><?php
	            if ($haslogininfo) {
	                echo $OUTPUT->login_info();
	            }
	            if (!empty($PAGE->layout_options['langmenu'])) {
	                echo $OUTPUT->lang_menu();
	            }
	            echo $PAGE->headingmenu
	        ?></div>
    <div id="headertabs">
	<?php if ($hascustommenu) { ?>
        	<div id="custommenu"><?php echo $custommenu; ?></div>
        <?php } ?>
        <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
        <?php //if(!empty($PAGE->button)){ ?>
        	<div class="navbutton"> <?php echo $PAGE->button; ?></div>
        <?php //} ?>
    </div>
</div> <!-- End Header -->
<div id="page">
	<?php echo $OUTPUT->main_content() ?>
</div> <!-- End Page -->
<div id="leftNav">
	<?php if ($hassidepre OR (right_to_left() AND $hassidepost)) { ?>
        <div id="region-pre" class="block-region">
            <div class="region-content">
                    <?php
                if (!right_to_left()) {
                    echo $OUTPUT->blocks_for_region('side-pre');
                } elseif ($hassidepost) {
                    echo $OUTPUT->blocks_for_region('side-post');
            } ?>

            </div>
        </div>
        <?php } ?>
</div> <!-- End Left Nav -->
<div id="footer">
    <div id="page-footer" class="clearfix">
        <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
        <?php
        echo '<div class="login">'.$OUTPUT->login_info().'</div>';
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
</div> <!-- End Footer -->
</div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>



