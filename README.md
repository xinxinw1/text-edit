# Simple Text Editor

This online text editor allows you to host your own editable documents on your website.
Useful for things like schedules and notes that you want to be able to access from anywhere in just one click.

## Installation

You need a server that runs php and git and has .htaccess and mod_rewrite enabled. Then cd to any directory and do

```
$ git clone https://github.com/xinxinw1/text-edit.git
```

Then visit `http://<your site>/<some directory>/text-edit/`

## Usage

To go to a page directly, go to `http://<your site>/<some directory>/text-edit/?name=<file name>`

To go to the admin panel, go to `http://<your site>/<some directory>/text-edit/admin`

It is recommended that you set a password.

If you forgot the password, delete `admin-pass`

All documents are stored under `docs/`. Names (but not contents) are base64-encoded.
