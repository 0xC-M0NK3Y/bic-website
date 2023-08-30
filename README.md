# bic-website

Build bic collection website from an excel file (.xlsx).

Actually on https://bicophile.fr

Take a look at update_bic_website, it does basically:  
  
+ Parse excel file into csv  
+ Transform csv into .sql  
+ Create database with this .sql  
+ Create the filters with the database  
+ Create the index.php  
+ Create the individual pages with the database

It has now accounts, you can select the bic you have and you want, you got 2 lists.
