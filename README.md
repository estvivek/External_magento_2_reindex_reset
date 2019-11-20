# External magento 2 reindex reset
## __PHP file using magento function to reindex reset or show status of indexers for magento 2__

![UI sample](https://i.imgur.com/Cqwsjpj.png)

__This file must be password protected all the times.__

Upload this file reindex_core.php to a new directory in document root ie: public_html.
Password protect the folder.

### For Cpanel / Centoswebpanel server

~~~nano /home/[username]/public_html/[new-dir-name]/.htaccess

##############htaccess##########

AuthName "[login user]"
  
AuthType Basic

AuthUserFile /home/[username]/.htpasswd
  
Require valid-user

###############

htpasswd -c /home/[username]/.htpasswd [login user]
  
Provide a password

chown [username]:[username] /home/[username]/.htpasswd
  
chmod 644 /home/[username]/.htpasswd 
~~~
  
### Many thanks to shyam krishna for his time.
