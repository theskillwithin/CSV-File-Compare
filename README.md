CSV-File-Compare
================

Compares a csv file against a text file to quickly find the cost of a free gift report



cvsfilecompare.php will read a file called test.csv which is a report generaed from a Magento site.

This is used to determine the cost of "free gifts" which are coupon codes in Magento that give you a gift item at checkout.

this will compare the generated report (test.csv) and get the prices for each coupon code from refrence.csv.

If the coupon code does not exist, bootstrap is ued to make that table row red.
There is a form at the bottom that allows you to add a new coupon code and price.

The descriptions are just for user convieniance. 

Created for skincarebyalana.com
Author Austin Peterson
