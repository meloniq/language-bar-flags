<?php
/**
 * Class extends WP CLI with custom commands to manage plugin from command line.
 */
class LangBF_WP_CLI_Command extends WP_CLI_Command {

	/**
	 * Subcommand to list all available commands.
	 *
	 * Examples:
	 * wp langbf help
	 *
	 * @subcommand help
	 */
	public function help( $args, $assoc_args ) {

		WP_CLI::line( 'enable              ' . __( 'Enables bar with lanuages', LANGBF_TD ) );
		WP_CLI::line( 'disable             ' . __( 'Disables bar with lanuages', LANGBF_TD ) );
		WP_CLI::line( 'position  <option>  ' . sprintf( __( 'Sets position of bar where <option> can be: %s', LANGBF_TD ), 'top, bottom' ) );
		WP_CLI::line( 'side      <option>  ' . sprintf( __( 'Sets side of flags where <option> can be: %s', LANGBF_TD ), 'left, right' ) );
		WP_CLI::line( 'newwindow <option>  ' . sprintf( __( 'Sets if links should be opened in new window where <option> can be: %s', LANGBF_TD ), 'yes, no' ) );
	}

	/**
	 * Subcommand to enable language bar.
	 *
	 * Examples:
	 * wp langbf enable
	 *
	 * @subcommand enable
	 */
	public function enable( $args, $assoc_args ) {

		update_option( 'langbf_active', 'yes' );

		$message = __( 'Enabled bar with lanuages!', LANGBF_TD );
		WP_CLI::success( $message );
	}

	/**
	 * Subcommand to disable language bar.
	 *
	 * Examples:
	 * wp langbf disable
	 *
	 * @subcommand disable
	 */
	public function disable( $args, $assoc_args ) {

		update_option( 'langbf_active', 'no' );

		$message = __( 'Disabled bar with lanuages!', LANGBF_TD );
		WP_CLI::success( $message );
	}

	/**
	 * Subcommand to set position of language bar.
	 *
	 * Examples:
	 * wp langbf position top
	 * wp langbf position bottom
	 *
	 * @subcommand position
	 */
	public function position( $args, $assoc_args ) {
		$positions = array( 'top', 'bottom' );

		if ( empty( $args[0] ) || ! in_array( $args[0], $positions ) ) {
			$message = sprintf( __( 'Missing or invalid position param! Valid are: %s', LANGBF_TD ), implode( ', ', $positions ) );
			WP_CLI::error( $message );
			return;
		}

		update_option( 'langbf_position', $args[0] );

		$message = __( 'Updated position of bar with lanuages!', LANGBF_TD );
		WP_CLI::success( $message );
	}

	/**
	 * Subcommand to set side of language flags on the bar.
	 *
	 * Examples:
	 * wp langbf side left
	 * wp langbf side right
	 *
	 * @subcommand side
	 */
	public function side( $args, $assoc_args ) {
		$sides = array( 'left', 'right' );

		if ( empty( $args[0] ) || ! in_array( $args[0], $sides ) ) {
			$message = sprintf( __( 'Missing or invalid side param! Valid are: %s', LANGBF_TD ), implode( ', ', $sides ) );
			WP_CLI::error( $message );
			return;
		}

		update_option( 'langbf_side', $args[0] );

		$message = __( 'Updated side of language flags on the bar!', LANGBF_TD );
		WP_CLI::success( $message );
	}

	/**
	 * Subcommand to set if links should be opened in new windows.
	 *
	 * Examples:
	 * wp langbf newwindow yes
	 * wp langbf newwindow no
	 *
	 * @subcommand newwindow
	 */
	public function newwindow( $args, $assoc_args ) {
		$options = array( 'yes', 'no' );

		if ( empty( $args[0] ) || ! in_array( $args[0], $options ) ) {
			$message = sprintf( __( 'Missing or invalid new window param! Valid are: %s', LANGBF_TD ), implode( ', ', $options ) );
			WP_CLI::error( $message );
			return;
		}

		update_option( 'langbf_new_window', $args[0] );

		$message = __( 'Updated new window option for opening links!', LANGBF_TD );
		WP_CLI::success( $message );
	}

}
