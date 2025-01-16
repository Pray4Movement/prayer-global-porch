<?php
declare( strict_types = 1 );

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * For more documentation, see the class Disciple_Tools_Migration in file
 * dt-core/migrations/abstract.php
 */
class Prayer_Global_Migration_Engine
{

    public static $migration_number = 1;

    protected static $migrations = null;
    
    public static $number_key = 'prayer_global_migration_number';
    public static $lock_key = 'prayer_global_migration_lock';
    public static $class_key = 'Prayer_Global_Migration';
    
    

    /**
     * @return array
     * @throws \Exception Could not scan migrations directory.
     */
    protected static function get_migrations(): array
    {

        if ( self::$migrations !== null ) {
            return self::$migrations;
        }
        require_once( plugin_dir_path( __DIR__ ) . 'migrations/abstract.php' );
        $filenames = scandir( plugin_dir_path( __DIR__ ) . 'migrations/', SCANDIR_SORT_ASCENDING );
        if ( $filenames === false ) {
            throw new Exception( 'Could not scan migrations directory' );
        }
        $expected_migration_number = 0;
        $rv = [];
        foreach ( $filenames as $filename ) {
            if ( $filename[0] !== '.' && $filename !== 'abstract.php' && $filename !== 'class-migration-engine.php' ){
                if ( preg_match( '/^([0-9][0-9][0-9][0-9])(-.*)?\.php$/i', $filename, $matches ) ) {
                    $got_migration_number = intval( $matches[1] );
                    if ( $expected_migration_number !== $got_migration_number ) {
                        throw new Exception( sprintf( 'Expected to find migration number %04d', $expected_migration_number ) );
                    }
                    require_once( plugin_dir_path( __DIR__ ) . "migrations/$filename" );
                    $migration_name = sprintf( self::$class_key .'_%04d', $got_migration_number );
                    $rv[] = new $migration_name();
                    $expected_migration_number++;
                } else {
                    throw new Exception( "Found filename that doesn't match pattern: $filename" );
                }
            }
        }
        self::$migrations = $rv;

        return self::$migrations;
    }

    /**
     * Migrate the database to the passed target migration number. If it is
     * already reached, do nothing.
     *
     * @param int $target_migration_number
     *
     * @throws \Exception ...
     * @throws \Prayer_Global_Migration_Lock_Exception ...
     * @throws \Throwable ...
     */
    public static function migrate( int $target_migration_number ) {
        //don't migrations run while doing cron to avoid race conditions
        if ( wp_doing_cron() ){
            return;
        }
        if ( $target_migration_number >= count( self::get_migrations() ) ) {
            throw new Exception( "Migration number $target_migration_number does not exist" );
        }

        while ( true ) {
            $current_migration_number = get_option( self::$number_key );
            if ( $current_migration_number === false ) {
                $current_migration_number = -1;
            }
            if ( !preg_match( '/^-?[0-9]+$/', (string) $current_migration_number ) ) {
                throw new Exception( "Current migration number doesn't look like an integer ($current_migration_number)" );
            }
            $current_migration_number = intval( $current_migration_number );

            if ( $target_migration_number === $current_migration_number ) {
                break;
            } elseif ( $target_migration_number < $current_migration_number ) {
                throw new Exception( 'Trying to migrate backwards, aborting' );
            }

            $activating_migration_number = $current_migration_number + 1;
            $migration = self::get_migrations()[ $activating_migration_number ];

            self::sanity_check_expected_tables( $migration->get_expected_tables() );

            if ( !empty( get_transient( self::$lock_key ) ) ) {
                throw new Disciple_Tools_Migration_Lock_Exception();
            }
            set_transient( self::$lock_key, '1', DAY_IN_SECONDS );

            error_log( gmdate( 'Y-m-d H:i:s T' ) . self::$class_key . ": Starting migrating to number $activating_migration_number" );
            try {
                $migration->up();
            } catch ( Throwable $e ) {
                update_option( 'pg_migrate_last_error', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTrace(),
                    'time' => time(),
                ] );
                throw $e;
            }
            update_option( self::$number_key, (string) $activating_migration_number );
            error_log( gmdate( 'Y-m-d H:i:s T' ) . self::$class_key . " Done migrating to number $activating_migration_number" );

            delete_transient( self::$lock_key );

            $migration->test();
        }
    }

    /**
     * @param array $expected_tables
     *
     * @throws \Exception Expected to find table name in table definition of $name.
     */
    protected static function sanity_check_expected_tables( array $expected_tables ) {
        global $wpdb;
        foreach ( $expected_tables as $name => $table ) {
            if ( preg_match( '/\bIF NOT EXISTS\b/i', $table ) ) {
                throw new Exception( "Table definition of $name should not contain 'IF NOT EXISTS'" );
            } elseif ( !preg_match( '/\b' . preg_quote( $name ) . '\b/', $table ) ) {
                throw new Exception( "Expected to find table name in table definition of $name" );
            } elseif ( strpos( $name, $wpdb->prefix ) !== 0 ) {
                throw new Exception( "Table name expected to start with prefix {$wpdb->prefix}" );
            }
        }
    }

    public static function get_current_db_migration(){
        return get_option( self::$number_key );
    }
}


class Prayer_Global_Migration_Lock_Exception extends Exception
{
    public function __construct( $message = null, $code = 0, Exception $previous = null ) {
        /*
         * Instead of throwing a simple exception that the migration lock is
         * held, it would be good for the user to if there any previous errors,
         * that caused the lock never to be released. We could rely on the
         * error logs, but this is a bit more user-friendly.
         */
        $last_migration_error = get_option( 'pg_migrate_last_error' );
        if ( $message === null ) {
            if ( $last_migration_error === false ) {
                $message = 'Cannot migrate, as migration lock is held';
            } else {
                $message =
                    'Cannot migrate, as migration lock is held. This is the previous stored migration error: '
                    . var_export( $last_migration_error, true );
            }
        }
        parent::__construct( $message, $code, $previous );
    }
}
