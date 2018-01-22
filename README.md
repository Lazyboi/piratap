# piratap
#You'll need Composer, Bower, and Gulp to edit/compile the backend and frontend of this project.

To run this system. go to C:\xampp\apache\conf\extra
Open httpd-vhosts.conf on any text editor 
Change the 2nd <VirtualHost *:80> to this:

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/piratap/public/"
</VirtualHost>
