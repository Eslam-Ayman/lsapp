<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    // if you need change table settings
    /*
    at this point you must know that when you calling any function in class post or model ,
    Eloquent by its selfe will use the popular version of the class name during the SQL query 
    ------
    so if you have model called "company" the >>>> company::all();
    so the query will be >>>> select * from companies
    -------
    and if the model called post >>>> post::all();
    the query will be >>>> select * from posts
    ------
    so you can solve tha by two ways 
    first >>> by naming the table in popular version 
    the second >>> by add property in the model called >>> $table = 'the name that you want here';
    and you must be with this name as the same >>> $table
    as i did in the next line
    */

    // table name 
    protected $table = 'posts';

    // Primary Key
    Public $primaryKey = 'id';

    // Timestamps
    Public $timestamps = true;

    Public function usr()
    {
        /* 
        * you must know that  through function called _get,  usr function  will be invoked
        * and create object with the same method function 
        * Eloquent determines the defualt forien key name by by examining the name
        * of the relationship method and suffixing the method name with _id.
        * However, if the forien key in the database table is user_id, you may pass a custom
        * key name as the second argument to the belongsto method;
        */
    	return $this->belongsTo('App\User', 'user_id');
    }
}
