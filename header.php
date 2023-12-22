<?php
/**
 * The template for displaying the header.
 *
 * Displays all the head elements and everything
 * up until the <main> element.
 *
 * @package MORPH
 * @since 0.0.1
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
