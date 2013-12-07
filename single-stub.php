<?php global $mdg_stub; ?>
<h2>Get Posts</h2>
<?php
$stubs1 = $mdg_stub->get_posts();
// pp( $stubs1 );
foreach ( $stubs1 as $stub ) {
	pp( $stub->post_title );
} // foreach()
?>

<h2>Get Posts Custom</h2>
<?php
$stubs2 = $mdg_stub->get_posts( array( 'posts_per_page' => 1 ) );
// pp( $stubs2 );
foreach ( $stubs2 as $stub ) {
	pp( $stub->post_title );
} // foreach()
?>

<h2>Get Posts With Thumbnails</h2>
<?php
$stubs3 = $mdg_stub->get_posts_with_featured_image();
// pp( $stubs3 );
foreach ( $stubs3 as $stub ) {
	pp( $stub->post_title );
} // foreach()
?>

<h2>Get Posts Attachments</h2>
<?php
$stubs4 = $mdg_stub->get_attachments( null, array() );
// pp( $stubs4 );
foreach ( $stubs4 as $stub ) {
	pp( wp_get_attachment_url( $stub->ID ) );
} // foreach()
?>

<h2>Get Posts Custom Query Object</h2>
<?php
$stubs3 = $mdg_stub->get_posts( array( 'posts_per_page' => 1 ), true );
pp( $stubs3 );
?>

<h3>Get Responsive Image Test</h3>
<?php
$resp_image = $mdg_stub->get_responsive_image( 'some_image', array( 'link' => 'test' ) );
?>
<!-- <h2>CSS3Pie Test</h3>
<div class="stub-css3pie-test pie">test</div>
<div class="test">Test2</div> -->

<!-- <h3>AJAX Loaders</h3>
<div class="small progress"><div>Loading…</div></div>
<div class="progress"><div>Loading…</div></div>
<div class="large progress"><div>Loading…</div></div> -->

<!-- <h3>LightBox Example</h3>
<a href="#" class="mdg-lightbox" data-content="<h4>test</h4>">Lightbox HTML Content</a><br>
<a href="#" class="mdg-lightbox" data-image="http://placehold.it/2800x530">Lightbox Image</a> -->