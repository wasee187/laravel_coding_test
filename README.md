# Product table Modification

As in product table there were no primary key and product id was not on auto increment mode, I was unable to get proper product id after saving it in database. I have tried several method in sql to get the proper data. So I modified the product table's id to primary key and added auto increment.

# method that I have tried

-   $data->save();
    $data->id;

-   DB::getPdo()->lastInsertId();
-   $id = DB::table('users')->insertGetId([
    ]);
