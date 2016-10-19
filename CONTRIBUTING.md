# Contribution Guidelines

In order to contribute to this project, you will need to install a few things.

You will need to install composer on you computer, but first there are a few things to confirm

 - You have PHP 5.4+ installed
 - You have OpenSSL installed
 - You have OpenSSL enabled in your php.ini file
 - You have Mcrypt installed
 - You have Mcrypt enabled in your php.ini file
 
Once you have verified the preceding, you can go ahead and install composer. 

 - [Windows](https://getcomposer.org/doc/00-intro.md)
 - [Mac](https://www.abeautifulsite.net/installing-composer-on-os-x)
 - [Linux](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)
 - PS. All of the instructions can be found on the first link, but the supplementary Mac and Linux links are more in depth.
 
I have never used Laravel + Git, so IDK how it will work. It seems like it requires some extensive settings and config specific
to your computer, which could be a problem.

## Once everything is installed
Once you have all the dependencies and extensions installed, it is time to start up the Laravel server. To do this, run 
the following in the terminal or cmd prompt on windows.

```
php artisan serve
```

This is also a good way to see which extensions and dependencies you have yet to install. For example, if you try to run the 
above, without Mcrypt installed, it will fail and say that you must install mcrypt first.

Once it succeeds, you can visit your live site in `localhost:8000` (By default, you can also specify a different port to host)


## Some problems I have run into and potentially some solutions

### Mcrypt Extension required
As I stated above, the PHP Mcrypt extension is required for this to work. 