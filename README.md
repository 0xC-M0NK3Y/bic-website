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
+ mini script to update colors from config file (not really used or usefull)
