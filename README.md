# Product table Modification

As in product table there were no primary key and product id was not on auto increment mode, I was unable to get proper product id after saving it in database. I have tried several method in sql to get the proper data. So I modified the product table's id to primary key and added auto increment.

# method that I have tried

-   $data->save();
    $data->id;

-   DB::getPdo()->lastInsertId();
-   $id = DB::table('users')->insertGetId([
    ]);

# Product create form modification

I have modified the product create form and use basic html, css, bootstrap for the form. I have created a separate card for variant and variant's price and stock. Using jquery I have created functions where user can add or remove card of variant in the form. In the database it will add only one variant at a time, with their corresponding price and stock.

# image reference (Task_Image folder)

-   Adding_data_1 to Adding_data_6

# Product List

In the product list I have managed to show data but not as per your given references. In the variant section I could not show data properly, so my table is showing single by single variant data for every product. I have managed to done the pagination and data summary.

# image reference (Task_Image folder)

-   All_product_list_1 to All_product_list_2

# Data Filter

# image reference (Task_Image folder)

-   All_product_list_1 to All_product_list_2
-   dynamic_variants
-   Search_Product

# Edit product

In the edit product section I only populated the product form with desire data and updated it accordingly.

# image reference (Task_Image folder)

-   edit_data_1 to edit_data_list_2
