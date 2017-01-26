# Plura auth plugin for WordPress

Plura auth plugin for Wordpress enables the plura forum site to use the plura auth api for SSO feature.
This plugin reference implementation could be used to add the similar function to your wordpress site if minor changes with your auth API.

Plura auth plugin for Wordpress requires PHP 5.4 or greater.

Current version: `1.0.0`

<a href="http://forum.plura.io/"><img src="https://camo.githubusercontent.com/bac41e1c6486ea0c3e5d10556676456a0323419a/68747470733a2f2f7472617669732d63692e6f72672f747769747465722f776f726470726573732e737667" alt="Build Status" style="max-width:100%;"></a>

## Functional Description

### 1. plura_auth.php

> constant variables for main/validate function

`FORUM_PLUGIN_DIR`: plugin directory

`PLURA_AUTH_DOMAIN`: Plura auth domain

`PLURA_AUTH_COOKIE`: Plura cookie name

`PLURA_AUTH_URL`, `PLURA_AUTH_DECRYPT_URL`: Plura cookie decrypt URL

### 2. class_plura_auth_main.php

> main implemeation for session, login, logout

Execute setSession_init, getLoginCheck method at *init* using wordpress's add_action function, *Logout (wp_logout)* with setLogOut method.

### 3. class_plura_auth_validate.php

> `PLURA_AUTH_COOKIE`(plura cookie) data validation. 

Send the cookie value to the `PLURA_AUTH_DECRYPT_URL` address with curl, and receive the related user context information.

The user context information could have (status, email, name, company name), which especially can be used to determine the validation of cookie with 'status' field) 

