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

If you forget the password, delete `data/admin-pass`

All documents are stored under `data/docs/`. Names (but not contents) are base64-encoded.

## Installation

You need a server that runs php and git and has .htaccess and mod_rewrite enabled. Then cd to any directory outside your web root and do

```
$ git clone https://github.com/xinxinw1/text-edit.git
```

Then copy the contents of `public/` into the directory you want to serve it from:

```
$ mkdir -p <your web directory>/text-edit
$ cp -r text-edit/public/. <your web directory>/text-edit/
```

(The `/.` at the end of `text-edit/public/.` copies the directory's contents, including
`.htaccess`. A `public/*` glob would skip it, and the rewrite rules would silently stop
working.)

Then visit `http://<your site>/<some directory>/text-edit/`

To update later, `git pull` in the clone and copy the contents of `public/` over again.

If you get a message saying `mkdir(): Permission denied` when saving, do

```
$ cd <your web directory>/text-edit
$ mkdir data
$ chmod a+w data
```

(Or use some other method to allow your server to write to the docs directory.)

## Upgrading from an in-place clone

Earlier versions were installed by cloning this repository directly into a web directory,
which left `.git` and the rest of the repository reachable over the web. The servable files
now live in `public/`, and installing copies that directory's contents into the web
directory, so the served directory is no longer a git clone.

To move an existing installation over:

1. Clone the repository somewhere outside your web root:

   ```
   $ git clone https://github.com/xinxinw1/text-edit.git
   ```

2. In your existing installation directory, delete everything except `data/`.

3. Copy the new files in:

   ```
   $ cp -r text-edit/public/. <your existing installation directory>/
   ```

Your documents are unaffected - `data/` stays where it is, alongside the PHP files, exactly
as before. The URL you visit does not change either.

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
