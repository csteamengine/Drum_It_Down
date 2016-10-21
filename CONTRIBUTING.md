# Contribution Guidelines
This project (At least my proposal) will be written with PHP, javascript, html, mysql and css. 

## File Structure

Each page will have it's own index.php file, inside it's own directory. This makes it really easy to redirect to a new page, 
and it also makes the url appear really clean. It allows for maximum code reusability, and in my opinion is really easy to read.

Any shared css, js, php, or images will be put inside the includes folder under the respective folder. 

## Code
There is an example php file that shows the basic outline of each php file. Basically, the top will have pre-processing code,
the middle will be the html code, under that will be javascript, and the very bottom will be page specific php functions

## IDE
I choose to use PHPStorm, by JetBrains. It is one of the best PHP editors out there, as it allows you to create a local php
server with just a few clicks. 

## PHP version
TBD, but most php is legacy friendly. We will say anything newer than 5.5

## MySQL
The mysql config file will need to be kept out of the git repo, for securities sake. We don't want our passwords and connection 
information online for people to see. To solve this, we will have a base.php file that is included in any php file requiring 
mysql information. If you are using a local mysql database, you could simply store the  username and password in a text file and
parse them out in base.php
