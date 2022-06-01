# Online Text Editor

This simple text editor allows you to host your own editable documents on your website.
Useful for things like schedules and notes that you want to be able to access from anywhere in just one click.

A demo is available at https://xin-xin.me/php/text-edit/

## Basic Usage

Go to `http://<your site>/<some directory>/text-edit/`, change "Title" to whatever file name you want, enter whatever text you want in the body, and press Ctrl-S to save. That's it!

## Advanced Usage

To go to a page directly, go to `http://<your site>/<some directory>/text-edit/?name=<file name>`

To go to the admin panel, go to `http://<your site>/<some directory>/text-edit/admin`

It is recommended that you set a password.

If you forget the password, delete `admin-pass`

All documents are stored under `docs/`. Names (but not contents) are base64-encoded.

## Installation

You need a server that runs php and git and has .htaccess and mod_rewrite enabled. Then cd to any directory and do

```
$ git clone https://github.com/xinxinw1/text-edit.git
```

Then visit `http://<your site>/<some directory>/text-edit/`

If you get a message saying `mkdir(): Permission denied` when saving, do

```
$ cd text-edit
$ mkdir data
$ chmod a+w data
```

(Or use some other method to allow your server to write to the docs directory.)

## Docker

### Build

```
$ docker build . -t xinxinw/text-edit
$ docker push xinxinw/text-edit
```

### Run

```
$ docker run -p 8080:80 -v "$PWD/data":/var/www/html/data:rw -d xinxinw/text-edit
```

## Get filenames

```
$ cd data/docs
$ ls -N | while read in; do echo "$in" | base64 -d; echo; done
```

## License

This program is dedicated to the public domain using the [Creative Commons CC0](http://creativecommons.org/publicdomain/zero/1.0/). See `LICENSE.txt` for details.
