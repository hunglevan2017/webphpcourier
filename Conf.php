<?php

class Conf {

    // var $is_main_db = false;
    // var $digi_soft_dbhost = '10.1.1.101';
    // var $digi_soft_dbport = '5432'; //Postgresql 9.5
    // var $digi_soft_dbname = 'production_test';
    // var $digi_soft_dbschema = 'db_p19001_c001_bak_contractprinting';
    // var $digi_soft_dbuser = 'postgres';
    // var $digi_soft_dbpass = 'S@GBtest2016';
    // var $digi_soft_version = 1.0;
    //
    // function __construct() {
    //     if ($this->is_main_db) {
    //         $this->digi_soft_dbhost = '10.1.1.101';
    //         $this->digi_soft_dbport = '5432';
    //         $this->digi_soft_dbname = 'production_test';
    //         $this->digi_soft_dbschema = 'db_p19001_c001_bak_contractprinting';
    //         $this->digi_soft_dbuser = 'postgres';
    //         $this->digi_soft_dbpass = 'S@GBtest2016';
    //         $this->digi_soft_version = 1.0;
    //     }
    // }

    /**
     *database chính
     * @var type
     * boolean
     */
    var $is_main_db = false;
    var $digi_soft_dbhost = '10.1.1.3';
    var $digi_soft_dbport = '5432'; //Postgresql 9.5
    var $digi_soft_dbname = 'production';
    var $digi_soft_dbschema = 'db_p19001_c001_bak_contractprinting';
    var $digi_soft_dbuser = 'user_p19001_c001_bak_contractprinting';
    var $digi_soft_dbpass = 'db@p19001_c001_bak_contractprinting';
    var $digi_soft_version = 1.0;

    function __construct() {
        if ($this->is_main_db) {
            $this->digi_soft_dbhost = '10.1.1.3';
            $this->digi_soft_dbport = '5432';
            $this->digi_soft_dbname = 'production';
            $this->digi_soft_dbschema = 'db_p19001_c001_bak_contractprinting';
            $this->digi_soft_dbuser = 'user_p19001_c001_bak_contractprinting';
            $this->digi_soft_dbpass = 'db@p19001_c001_bak_contractprinting';
            $this->digi_soft_version = 1.0;
        }
    }

}

?>
